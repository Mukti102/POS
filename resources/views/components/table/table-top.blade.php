@props(['pdf' => null, 'excel' => null, 'print' => null])
<div class="table-top">
    <div class="search-set">
        <div class="search-path">
            <a class="btn btn-filter" id="filter_search">
                <img src="/assets/img/icons/filter.svg" alt="img" />
                <span><img src="/assets/img/icons/closes.svg" alt="img" /></span>
            </a>
        </div>
        <div class="search-input">
            <a class="btn btn-searchset"><img src="/assets/img/icons/search-white.svg" alt="img" /></a>
        </div>
    </div>
    <div class="wordset">
        <ul>
            @isset($pdf)
                <li>
                    <a href="{{$pdf}}" data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="/assets/img/icons/pdf.svg"
                            alt="img" /></a>
                </li>
            @endisset
            @isset($excel)
                <li>
                    <a href="{{$excel}}" data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="/assets/img/icons/excel.svg"
                            alt="img" /></a>
                </li>
            @endisset
            @isset($print)
                <li>
                    <a href="{{$print}}" data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                            src="/assets/img/icons/printer.svg" alt="img" /></a>
                </li>
            @endisset
        </ul>
    </div>
</div>
