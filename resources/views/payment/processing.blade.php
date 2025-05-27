@extends('layouts.master')
@section('content')
<div id="box" class="text-center mt-10">
   <h1 class="text-2xl font-bold" id="title">جاري معالجة عملية الدفع…</h1>
   <p class="mt-4 text-gray-600" id="msg">سيتم تحويلك تلقائياً بعد التأكيد.</p>
</div>

<script>
const id   = "{{ $orderId }}";
function poll(){
  fetch('/btcpay/status/'+id)
    .then(r=>r.json())
    .then(d=>{
        if(d.status==='completed'){
            window.location = '/btcpay/success/'+id;
        }else if(d.status==='failed'){
            document.getElementById('title').innerText = 'فشلت عملية الدفع ❌';
            document.getElementById('msg').innerText   = 'للأسف انتهت صلاحية الفاتورة أو لم يتم الدفع. حاول مرة أخرى.';
        }else{
            setTimeout(poll, 3000);
        }
    });
}
poll();
</script>
@endsection
