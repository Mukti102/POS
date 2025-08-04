@extends('layouts.main')
@section('content')
    <x-layout.page-header title="Detail Trnsaksi" subtitle="Detail Transaksi {{ $transaction->reference }}" />

    <div class="card">
        <div class="card-body">
            <div class="card-sales-split">
                <h2>Sale Detail : {{ $transaction->reference }}</h2>
                <ul>

                    <li>
                        <a href="javascript:void(0);"><img src="/assets/img/icons/pdf.svg" alt="img" /></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><img src="/assets/img/icons/excel.svg" alt="img" /></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><img src="/assets/img/icons/printer.svg" alt="img" /></a>
                    </li>
                </ul>
            </div>
            <div class="invoice-box table-height"
                style="
                  max-width: 1600px;
                  width: 100%;
                  overflow: auto;
                  margin: 15px auto;
                  padding: 0;
                  font-size: 14px;
                  line-height: 24px;
                  color: #555;
                ">
                <table cellpadding="0" cellspacing="0" style="width: 100%; line-height: inherit; text-align: left">
                    <tbody>
                        <x-transaction-detail.top :transaction="$transaction" />
                        <tr class="heading" style="background: #f3f2f7">
                            <td
                                style="
                          padding: 5px;
                          vertical-align: middle;
                          font-weight: 600;
                          color: #5e5873;
                          font-size: 14px;
                          padding: 10px;
                        ">
                                Product Name
                            </td>
                            <td
                                style="
                          padding: 5px;
                          vertical-align: middle;
                          font-weight: 600;
                          color: #5e5873;
                          font-size: 14px;
                          padding: 10px;
                        ">
                                QTY
                            </td>
                            <td
                                style="
                          padding: 5px;
                          vertical-align: middle;
                          font-weight: 600;
                          color: #5e5873;
                          font-size: 14px;
                          padding: 10px;
                        ">
                                Price
                            </td>
                            <td
                                style="
                          padding: 5px;
                          vertical-align: middle;
                          font-weight: 600;
                          color: #5e5873;
                          font-size: 14px;
                          padding: 10px;
                        ">
                                Discount
                            </td>
                            <td
                                style="
                          padding: 5px;
                          vertical-align: middle;
                          font-weight: 600;
                          color: #5e5873;
                          font-size: 14px;
                          padding: 10px;
                        ">
                                TAX
                            </td>
                            <td
                                style="
                          padding: 5px;
                          vertical-align: middle;
                          font-weight: 600;
                          color: #5e5873;
                          font-size: 14px;
                          padding: 10px;
                        ">
                                Subtotal
                            </td>
                        </tr>

                        @foreach ($transaction->transactionItems as $product)
                            <tr class="details" style="border-bottom: 1px solid #e9ecef">
                                <td
                                    style="
                          padding: 10px;
                          vertical-align: top;
                          display: flex;
                          align-items: center;
                        ">
                                    <img src="{{$product->product->image ? asset('storage/'.$product->product->image) : '/assets/img/product/product8.jpg'}}" alt="img" class="me-2"
                                        style="width: 40px; height: 40px" />
                                    {{$product->name}}
                                </td>
                                <td style="padding: 10px; vertical-align: top">{{$product->quantity}}</td>
                                <td style="padding: 10px; vertical-align: top">
                                   Rp {{ number_format($product->product->selling_price, 0, ',', '.') }}
                                </td>
                                <td style="padding: 10px; vertical-align: top">0.00</td>
                                <td style="padding: 10px; vertical-align: top">0.00</td>
                                <td style="padding: 10px; vertical-align: top">
                                   Rp {{ number_format($product->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="row">
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="total-order w-100 max-widthauto m-auto mb-4">
                            <ul>
                                <li>
                                    <h4>Order Tax</h4>
                                    <h5>Rp 0.00 (0.00%)</h5>
                                </li>
                                <li>
                                    <h4>Discount</h4>
                                    <h5>Rp 0.00</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="total-order w-100 max-widthauto m-auto mb-4">
                            <ul>
                                
                                <li class="total">
                                    <h4>Grand Total</h4>
                                    <h5>Rp {{ number_format($transaction->total, 0, ',', '.') }}</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <a href="javascript:void(0);" class="btn btn-submit me-2">Update</a>
                    <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection
