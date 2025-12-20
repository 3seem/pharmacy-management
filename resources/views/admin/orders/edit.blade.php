@extends('layouts.testlayout')

<style>
.table-edit { width:100%; margin-top:20px; border-collapse:collapse; }
.table-edit th, .table-edit td {
    border:1px solid #333; padding:10px; color:white;
}
.save-btn {
    background:#2ecc71;color:white;padding:10px 25px;border-radius:8px;
}
.btn-red{background:#e53935;color:white;padding:6px 14px;border-radius:6px;}
.input-dark{background:#000;color:white;border:none;padding:6px 10px;border-radius:4px;}
</style>
<br><br><br><br><br>
<div class="wrapper">

<h2 style="color:white;">Edit Order #{{ $order->Order_ID }}</h2>
<h3 style="color:white; margin-bottom:15px;">
    Total Amount: $<span id="order-total">{{ number_format($order->Total_amount, 2) }}</span>
</h3>

<form action="{{ route('orders.updateItems', $order->Order_ID) }}" method="POST">
    @csrf

    <table class="table-edit">
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
                <th>delete</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>
                    {{ $item->medicine->Name ?? 'Unknown Medicine'  }}
                    <!-- Hidden input moved inside td -->
                    <input type="hidden" name="items[{{ $loop->index }}][medicine_id]" 
                           value="{{ $item->medicine_id }}">
                </td>

                <td>
                    <input type="number" name="items[{{ $loop->index }}][Quantity]"
                        value="{{ $item->Quantity }}" min="1" class="input-dark" style="background-color: black"/>
                </td>

                <td>
                    <input disabled type="number" name="items[{{ $loop->index }}][unit_price]"
                        value="{{ $item->medicine->Price }}"  class="input-dark" style="background-color: black" />
                </td>

                <td>${{ $item->subtotal }}</td>
                
                <td>
                    <!-- Button moved outside the main form -->
                    <button type="button" class="btn-red" 
                            onclick="deleteItem('{{ route('orders.items.delete', [$order->Order_ID, $item->medicine_id]) }}')">
                        🗑️
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button class="save-btn" style="margin-top:20px;">Save Changes</button>

</form>

<!-- Separate hidden form for deletes -->
<form id="delete-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

</div>
<script>
document.querySelectorAll('input[name^="items"]').forEach(input => {
    input.addEventListener('input', () => {
        let total = 0;

        document.querySelectorAll('tbody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('input[name*="[Quantity]"]').value) || 0;
            const price = parseFloat(row.querySelector('input[name*="[unit_price]"]').value) || 0;
            const subtotalCell = row.cells[3];
            const subtotal = qty * price;
            subtotalCell.innerText = '$' + subtotal.toFixed(2);
            total += subtotal;
        });

        document.getElementById('order-total').innerText = total.toFixed(2);
    });
});

function deleteItem(url) {
    if (confirm('Delete this item?')) {
        const form = document.getElementById('delete-form');
        form.action = url;
        form.submit();
    }
}
</script>