from fastapi import FastAPI
from pydantic import BaseModel
from langchain_community.vectorstores import FAISS
from langchain_community.embeddings import HuggingFaceEmbeddings
from groq import Groq
import os
from dotenv import load_dotenv
from fastapi.middleware.cors import CORSMiddleware

# conda activate rag_env
# uvicorn ai_service:app --reload --port 8001
# http://127.0.0.1:9000/docs  for test



load_dotenv()
app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],       
    allow_credentials=True,
    allow_methods=["*"],       
    allow_headers=["*"],      
)

# ===== LOAD EMBEDDINGS =====
embeddings = HuggingFaceEmbeddings(
    model_name="sentence-transformers/all-MiniLM-L6-v2"
)

# ===== LOAD VECTOR DB =====
vectorstore = FAISS.load_local(
    "drug_vector_db",
    embeddings,
    allow_dangerous_deserialization=True
)

retriever = vectorstore.as_retriever(search_kwargs={"k": 5})

# ===== GROQ =====
groq_api_key = os.getenv("groq_api_key")

client = Groq(api_key=groq_api_key)

class Question(BaseModel):
    question: str

def ask_llm(question, context):
    prompt = f"""
You are a smart AI assistant.

Your behavior depends on the type of question:

1. If the question is MEDICAL or about drugs:
   - Use ONLY the provided context to answer.
   - If the answer EXISTS in the context:
       - Provide a clear medical answer.
       - Add this disclaimer at the end:
         "This information does not replace consultation with a licensed physician or pharmacist."
   - If the answer is NOT found in the context:
       - Reply ONLY with:
         "I could not find this information in the Egyptian Drug Authority database."
       - Do NOT add any disclaimer.

2. If the question is NOT medical (general knowledge, casual talk, people, sports, etc.):
   - Ignore the medical context completely.
   - Answer normally using general knowledge.
   - Do NOT add any medical disclaimer.

Context:
{context}

Question:
{question}

Answer:
"""
    res = client.chat.completions.create(
        model="llama-3.1-8b-instant",
        messages=[{"role": "user", "content": prompt}],
        temperature=0
    )
    return res.choices[0].message.content

@app.post("/ask")
def ask_ai(q: Question):
    docs = retriever.get_relevant_documents(q.question)
    context = "\n\n".join([d.page_content for d in docs])
    answer = ask_llm(q.question, context)
    return {"answer": answer}


