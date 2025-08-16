@props(['action' => 'product.index' ]) 
 <div class="card" id="filter_inputs">
     <div class="card-body pb-0">
         <form action="{{route($action)}}" method="GET" class="row">
            @csrf
             {{$slot}}
             <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                 <button  type="submit" class="btn btn-filters ms-auto form-group">
                     <a class="btn btn-filters ms-auto"><img src="assets/img/icons/search-whites.svg"
                             alt="img" /></a>
                 </button>
             </div>
         </form>
     </div>
 </div>
