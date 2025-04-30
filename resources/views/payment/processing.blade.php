@extends('layouts.app')
@section('content')
<div class="text-center mt-10">
  <h1 class="text-2xl font-bold">جاري معالجة عملية الدفع…</h1>
  <p class="mt-4 text-gray-600">سيتم تحويلك تلقائياً بعد التأكيد.</p>
  <script>
     const order='{{ $orderId }}';
     const poll = () => fetch('/btcpay/status/'+order)
        .then(r=>r.json())
        .then(d=>{ if(d.status==='completed'){ window.location='/btcpay/success/'+order; } else { setTimeout(poll,3000);} });
     poll();
  </script>
</div>
@endsection
