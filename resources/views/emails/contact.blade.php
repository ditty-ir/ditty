@component('mail::message')
<div dir="rtl" style="text-align: right;font-family: tahoma">
    <div style="margin-bottom: 15px;">
        <b>نام:</b><span>{{ $request->name }}</span>
    </div>
    <div style="margin-bottom: 15px;">
        <b>ایمیل:</b><span>{{ $request->email }}</span>
    </div>
    <div style="margin-bottom: 15px;">
        <b>متن:</b>
        <br>
        <p>{{ $request->text }}</p>
    </div>
</div>
@endcomponent