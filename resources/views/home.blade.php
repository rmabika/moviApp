@extends('layouts.app')

@section('content')
<div class="container justify-content-center">
    <div class="row ">
        <div class="col-md-12 mb-2" >
        
 @foreach(array_chunk($result['movies']->results,3) as $chunk)
     

     <div class="card-deck" style="align-content:justify; margin-bottom: 5px ">

         <div class="row">

        @foreach($chunk as $add)
        <div class="col-md-3">
          <div class="card">

            <img src="https://image.tmdb.org/t/p/w500/{{$add->backdrop_path}}" class="card-img-top" style="">
            <div class="card-body">
              <h5 class="card-title">{{$add->original_title}}</h5>
              <p class="card-text"><small class="text-muted">Release Date: {{$add->release_date}}</small></p>
            </div>
            <button type="button" data-title="{{$add->original_title}}" class="btn btn-secondary" onclick="test('<?php echo $add->original_title?>', '<?php echo $add->release_date?>', '<?php echo $add->backdrop_path?>')">Add to Favorite</button>

          </div>
     </div>
  @endforeach

        </div>
     </div>


@endforeach
            
 
     </div>
        </div>
    </div>
</div>


    <script>

// A $( document ).ready() block.
$( document ).ready(function() {
    




});



function test(title, release_date, image_path){

               // alert(image_path);

              //   Swal.fire(
              // 'Good job!',
              // 'You clicked the button!',
              // 'success'
              //   )



            // Swal.fire({
            //   title: 'Confirm!',
            //   text: 'Do you want to continue',
            //   icon: 'danger',
            //   confirmButtonText: 'Cool',
            //     confirmButtonText: 'Cool'
            // })


            if(title !='' && release_date != '' && image_path !=''){


                Swal.fire({
                  title: 'Are you sure, you want to add this movie to your favorites list ?',
         
                  showCancelButton: true,
                  confirmButtonText: 'Yes',
                  customClass: {
                    actions: 'my-actions',
                    cancelButton: 'order-1 right-gap',
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                  }
                }).then((result) => {
                  if (result.isConfirmed) {

                      $.ajax({
                       type:'POST',
                       url:'{{ url('add-favorite')}}',
                           headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                       data:{'title': title, 'release_date': release_date, 'image_path': image_path},
                       success:function(data) {
                        var obj = JSON.parse(data);
                        console.log();

                        if(obj.status == 'error'){

                              Swal.fire(
                               'Sorry!',
                               'Movie already added to the list !',
                               'error'
                                 )
                        }else if(obj.status=='success'){

                             Swal.fire('Movie added to your favorites list', '', 'success')

                        }


                       }

                     });


                   
                  } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                  }
                })


            }

        

}

</script>

@endsection



