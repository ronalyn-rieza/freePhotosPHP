<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        //capitalized first letter
        $('.fl-cap').keyup(function() {

            var caps = $(this).val();

            caps = caps.charAt(0).toUpperCase() + caps.slice(1);

            $(this).val(caps);
	   });

        //show delete category modal
        $('.delete-cat').click(function(){

            var delete_cat_id = $(this).attr('data-id');

            $.ajax({

                url:'modal.php?delete_cat='+delete_cat_id,
                cache:false,
                success:function(result){

                    $('.modal-content').html(result);
                }
            })
        });

        //show delete user modal
        $(".delete-user").on('click', function(){
            var delete_user_id = $(this).attr('data-id');

            $.ajax({

                url:'modal.php?delete_user='+delete_user_id,
                cache:false,
                success:function(result){

                    $('.modal-content').html(result);
                }
            })
        });

        //show delete image modal
        $('.delete-image').click(function(){

            var delete_image_id = $(this).attr('data-id');

            $.ajax({

                url:'modal.php?delete_image='+delete_image_id,
                cache:false,
                success:function(result){

                    $('.modal-content').html(result);
                }
            })
        });

       //show view image modal
       $('.view-image').click(function(){

            var dataId = $(this).attr('data-id');

            $.ajax({

                url:'modal.php?dataId='+dataId,
                cache:false,
                success:function(result){

                    $('.modal-content').html(result);
                }
            })
        });

    });//end of document ready function
</script>

</body>
</html>
