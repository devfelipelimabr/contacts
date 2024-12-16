 @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
             <i class="fa-solid fa-circle-exclamation">&nbsp;</i>
             {{ $error }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
     @endforeach
 @endif

 @if (session('success'))
     <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
         <i class="fa-solid fa-check">&nbsp;</i>
         {{ session('success') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
 @endif
 @if (session('error'))
     <div class="alert alert-warning  alert-dismissible fade show mt-3" role="alert">
         <i class="fa-solid fa-triangle-exclamation">&nbsp;</i>
         {{ session('error') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
 @endif
