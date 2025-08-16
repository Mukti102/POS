@extends('layouts.main')
@section('content')
    <x-layout.page-header title="Detail Mutasi Transnfer Stock" subtitle="Detail Transaksi {{ $stockTransfer->reference }}" />

    <div class="card">
        <div class="card-body">
            <div class="card-sales-split">
                <h2>Sale Detail : {{ $stockTransfer->reference }}</h2>
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

                        <tr class="top">
                            <td colspan="6" style="padding: 5px; vertical-align: top">
                                <table
                                    style="
                            width: 100%;
                            line-height: inherit;
                            text-align: left;
                          ">
                                    <tbody>
                                        <tr>
                                            <td
                                                style="
                                  padding: 5px;
                                  vertical-align: top;
                                  text-align: left;
                                  padding-bottom: 20px;
                                ">
                                                <font
                                                    style="
                                    vertical-align: inherit;
                                    margin-bottom: 25px;
                                  ">
                                                    <font
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #7367f0;
                                      font-weight: 600;
                                      line-height: 35px;
                                    ">
                                                        Cabang Awal</font>
                                                </font><br />
                                                <font style="vertical-align: inherit">
                                                    <font
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                                        {{ $stockTransfer->fromBranch->name }}</font>
                                                </font><br />

                                                <font style="vertical-align: inherit">
                                                    <font
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                                        {{ $stockTransfer->fromBranch->phone }}</font>
                                                </font><br />

                                            </td>

                                            <td
                                                style="
                                  padding: 5px;
                                  vertical-align: top;
                                  text-align: left;
                                  padding-bottom: 20px;
                                ">
                                                <font
                                                    style="
                                    vertical-align: inherit;
                                    margin-bottom: 25px;
                                  ">
                                                    <font
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #7367f0;
                                      font-weight: 600;
                                      line-height: 35px;
                                    ">
                                                        Cabang Tujuan</font>
                                                </font><br />
                                                <font style="vertical-align: inherit">
                                                    <font
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                                        {{ $stockTransfer->toBranch->name }}
                                                    </font>
                                                </font><br />
                                                <font style="vertical-align: inherit">
                                                    <font
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                                        {{ $stockTransfer->toBranch->phone }}

                                                    </font>
                                                </font><br />

                                            </td>
                                            <td
                                                style="
                                  padding: 5px;
                                  vertical-align: top;
                                  text-align: right;
                                  padding-bottom: 20px;
                                ">
                                                <font
                                                    style="
                                    vertical-align: inherit;
                                    margin-bottom: 25px;
                                  ">
                                                    <font
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #7367f0;
                                      font-weight: 600;
                                      line-height: 35px;
                                    ">
                                                        &nbsp;</font>
                                                </font><br />
                                                <font style="vertical-align: inherit">
                                                    <font
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                                        {{ $stockTransfer->reference }}
                                                    </font>
                                                </font><br />
                                                <font style="vertical-align: inherit">
                                                    <font
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                                        {{ \Carbon\Carbon::parse($stockTransfer->date)->translatedFormat('d F Y') }}
                                                    </font>
                                                </font><br />

                                                <font style="vertical-align: inherit">
                                                    <font class="text-capitalize"
                                                        style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #2e7d32;
                                      font-weight: 400;
                                    ">
                                                        @if ($stockTransfer->status == 'complete')
                                                            <span class="badge bg-success">
                                                                {{ $stockTransfer->status }}
                                                            </span>
                                                        @endif


                                                    </font>
                                                </font><br />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>






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
                                Subtotal
                            </td>
                        </tr>

                        @foreach ($stockTransfer->transferItems as $product)
                            <tr class="details" style="border-bottom: 1px solid #e9ecef">
                                <td
                                    style="
                          padding: 10px;
                          vertical-align: top;
                          display: flex;
                          align-items: center;
                        ">
                                    <img src="{{ $product->product->image ? asset('storage/' . $product->product->image) : '/assets/img/product/product8.jpg' }}"
                                        alt="img" class="me-2" style="width: 40px; height: 40px" />
                                    {{ $product->product->name }}
                                </td>
                                <td style="padding: 10px; vertical-align: top">{{ $product->quantity }}</td>
                                <td style="padding: 10px; vertical-align: top">
                                    Rp {{ number_format($product->cost_price, 0, ',', '.') }}
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


                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="total-order w-100 max-widthauto m-auto mb-4">
                            <ul>
                                <li>
                                    <h4>Subtotal</h4>
                                    <h5>Rp
                                        {{ number_format($stockTransfer->transferItems->sum('cost_price'), 0, ',', '.') }}
                                    </h5>
                                </li>
                                <li>
                                    <h4>Discount</h4>
                                    <h5>{{ $stockTransfer->discount ?? 0 }}%</h5>
                                </li>
                                <li class="total">
                                    <h4>Grand Total</h4>
                                    <h5>Rp
                                        {{ number_format($stockTransfer->transferItems->sum('cost_price'), 0, ',', '.') }}
                                    </h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-12">
                    <a href="javascript:void(0);" class="btn btn-submit me-2">Update</a>
                    <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
