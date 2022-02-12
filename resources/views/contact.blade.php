@extends('layouts.app')

@section('content')
<div class="container justify-content-center">
    <div class="row ">
        <div class="col-md-8 mb-2" >
        
      
             <div class="card-deck" style="align-content:justify; margin-bottom: 5px ">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Reagan Mabika</h5>
              <p class="card-text">Mobile Number: +27 73 691 7540</p>
              <p class="card-text">Email Address: reagmbk@gmail.com</p>
              <p class="card-text">Social Media Links</h6>
               <h6 class="card-text">Linkedin : https://www.linkedin.com/in/reagan-mabika-b4b6867b</p>
                <p class="card-text">Twitter: https://twitter.com/mabikargm</p>
                 <p class="card-text">Facebook: https://www.facebook.com/reagan.mbk/</p>
                 <p class="card-text">Github: https://github.com/rmabika</p>
            </div>
          </div>


        </div>
     </div>

            
 
     </div>
 
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



