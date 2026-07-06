import json
from langchain.schema import Document
from langchain_community.vectorstores import FAISS
from langchain_community.embeddings import HuggingFaceEmbeddings

docs=[]
with open(r"C:\Users\mahmo\Downloads\Egyptian_Drugs_150.jsonl","r")as f:
    for line in f:
        data=json.loads(line)
        text = f"""
        Brand Name: {data['Brand Name']}
        Generic Name: {data['Generic Name']}
        Therapeutic Class: {data['Therapeutic Class']}
        Indications: {data['Indications/Uses']}
        Dosage: {data['Dosage']}
        Warnings: {data['Warnings']}
        Interactions: {data['Interactions']}
        Source: {data['Source']}
        """
        docs.append(
            Document(
                page_content=text,
                metadata={
                    "brand": data["Brand Name"],
                    "generic": data["Generic Name"],
                    "class": data["Therapeutic Class"]
                }
            )
        )


embeddings = HuggingFaceEmbeddings(
    model_name="sentence-transformers/all-MiniLM-L6-v2"
)
vectorstore = FAISS.from_documents(docs, embeddings)
retriever = vectorstore.as_retriever(search_kwargs={"k": 5})

vectorstore.save_local("drug_vector_db")