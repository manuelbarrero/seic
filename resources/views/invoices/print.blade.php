<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Presupuesto 00{{ $invoice->id }}</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
        font-size: 14px;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    .text-right {
      text-align: right!important;
    }
    .text-center {
      text-align: center!important;
    }
    .font-16 {
      font-size: 12;
    }

    table {
      border-collapse: collapse;
    }
    .table-bordered{
      border: 1px solid #999999;
    }
    .table-bordered th, .table-bordered td {
      border: 1px solid #999999;
      padding-top: 5px;
      padding-bottom: 5px;
      padding-right: 3px;
      padding-left: 3px;
    }
    .page-break {
        page-break-after: always;
    }

</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td valign="top"><img src="{{asset('images/interdatos.jpg')}}" alt="" width="220"/></td>
        <td class="text-right">
            <div style="font-size: 14px;">Interdatos, C.A.</div>
            <div style="font-size: 12px;">
              J-30993349-3<br>
              info@interdatos.net<br>
              +58 0424 667.8700<br>
            </div>
        </td>
    </tr>
  </table>

  <table width="100%" style="margin-top: 40px;">
    <tr>
        <td>
          <div style="font-size: 18px; font-weight: bold;">{{ $invoice->contact->name }}</div>
          <b>Identificador:</b> {{ $invoice->contact->identifier }} <br>
          {{ $invoice->contact->address }}<br>
          {{ $invoice->contact->city }}, {{ $invoice->contact->state }}
        </td>
        <td class="text-right" style="font-size: 18px; vertical-align: top;">
         Presupuesto No.: <span style="color: red; font-size: 18px;">00{{ $invoice->id }}</span><br>
         Fecha: {{ $invoice->date->format('d/m/Y') }}
        </td>
    </tr>
  </table>

  <br/>
  <table class="table-bordered" width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th colspan="2">Periodo Cubierto</th>
        <th>Descripción</th>
        <th>Monto $</th>
      </tr>
    </thead>
    <tbody>
      @foreach($invoice->invoiceItems as $item)
      <tr>
        <td class="text-center" style="width: 12%;">{{ $item->date_from?->format('d/m/Y') }}</td>
        <td class="text-center" style="width: 12%;">{{ $item->date_to?->format('d/m/Y') }}</td>
        <td>{{ $item->description }}</td>
        <td class="text-right" style="width: 12%;">{{ $item->total }}</td>
      </tr>
      @endforeach
    </tbody>
    <tr>
        <td colspan="3" class="text-right">Sub Total</td>
        <td class="text-right">{{ $invoice->sub_total }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">IVA {{ $invoice->tax_rate }}%</td>
        <td class="text-right">{{ $invoice->tax_amount }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right font-16">Total</td>
        <td class="text-right font-16" class="gray">{{ $invoice->total }}</td>
    </tr>
  </table>

  <div style="margin-top: 30px;">Formas de pago</div>
  <table class="table-bordered">
    {{-- <tr>
        <td valign="top">
          <img src="{{asset('images/zelle.png')}}" width="150"/></td>
        <td>
        Nombre: Miguel Barrero<br>
        Email: miguel@interdatos.net
        </td>
    </tr> --}}
    <tr>
        <td valign="top">
          <img src="{{asset('images/banesco.png')}}" width="150"/>
        </td>
        <td>
        Banesco Cuenta Nº 01340073310731057842<br>
        Titular: INTERDATOS, C.A.<br>
        RIF: J-30993349-3<br>
        </td>
    </tr>
  </table>
  <div>Los pagos en Bolívares se deben calcular a la taza de BCV.</div>

</body>
</html>