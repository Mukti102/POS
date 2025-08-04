<div class="col-lg-5 col-sm-12 col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Kasbon Jatu Tempo</h4>
                    <div class="dropdown">
                        <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a href="{{route('debt.index')}}" class="dropdown-item">Data Kasbon</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive dataview">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Costumer</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($todayDebt as $debt)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$debt->transaction->costumer->name}}</td>
                                    <td>Rp. {{ number_format($debt->remaining, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                    <tr>
                                        <td>
                                            Tidak Ada Data
                                        </td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>