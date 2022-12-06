<div id="main">
    <div id="content">
      <div class="box">
        <div class="head">
        </div>
        <div id="movie">
            <div class="loader"></div>
            <div class="row">
                <div id="m-pic" class="col-6"></div>
                <div id="m-details" class="col-6"></div>
            </div>
            <form class="mt-5" id="comment-form" hidden>
            <div class="alert alert-primary" role="alert" hidden></div>
            <h4 class="text-light border-bottom">Post a comment</h4>
            <div class="mb-3">
  <label for="" class="form-label text-light">Name</label>
  <input type="text" class="form-control" name="name" required>
</div>
<input type="hidden" name="token" value="<?=isset($_SESSION["token"]) ? $_SESSION["token"] : ''?>"/>
<input id="m-id" type="hidden" name="movieId"/>
<div class="mb-3">
  <label for="" class="form-label text-light">Comment</label>
  <textarea class="form-control" name="comment" rows="3" required></textarea>
</div>
<?=isset($_SESSION["token"]) ? '<button type="submit" class="btn btn-primary mb-3 w-25">Submit</button>' : '<p class="text-light">Only logged in users can post comments</p>'?>
            </form>
        </div>
        <div class="cl">&nbsp;</div>
      </div>
    </div>
    <div class="cl">&nbsp;</div>
  </div>
  <script>
    fetch('<?=URL?>' + '/api/getsinglemovie', {method: 'POST', body: JSON.stringify({slug: '<?=$data['slug']?>'}) })
    .then(response => response.json())
    .then(data => {console.log(data)
      $('.loader').remove()
      if(data.status && data.data.length != 0){
          $('#m-pic').html(`<img class="w-100" src="${data.data.photo}" />`)
          $('#m-details').append(`<p class="text-light border-bottom">Name: ${data.data.name}</p>`)
          $('#m-details').append(`<p class="text-light border-bottom">Description: ${data.data.description}</p>`)
          $('#m-details').append(`<p class="text-light border-bottom">Release Date: ${data.data.release_date}</p>`)
          $('#m-details').append(`<p class="text-light border-bottom">Rating: ${data.data.rating} star(s)</p>`)
          $('#m-details').append(`<p class="text-light border-bottom">Ticket Price: ${data.data.ticket_price}</p>`)
          $('#m-details').append(`<p class="text-light border-bottom">Country: ${data.data.country}</p>`)
          $('#m-details').append(`<p class="text-light border-bottom">Genre: ${data.data.genre.slice(0, -1).replaceAll(',', ', ')}</p>`)
          $('#m-id').val(data.data.id)
          $('#comment-form').attr('hidden', false)
          fetchComments(data.data.id)
      } else if(data.data.length == 0) {
        $('#movie').html('<h5 class="text-light" style="margin: auto">No movie with slug name</h5>')
      } else{
        $('#movie').html('<h5 class="text-light" style="margin: auto">Unexpected error fetching data</h5>')
      }
    })
    .catch(error => console.error(error));

   function fetchComments(movie_id){
        $('#movie').append(`<div class="my-5"><h4 class="text-light border-bottom">Comments</h4><div class="loader"></div><div id="comment-list"></div></div>`)
    fetch('<?=URL?>' + '/api/getmoviecomments', {method: 'POST', body: JSON.stringify({movie_id: movie_id}) })
    .then(response => response.json())
    .then(data => {
      $('.loader').remove()
      if(data.status){
        data.data.map((row) => {
          $('#comment-list').append(`
          <div class="text-light mb-3"><h6>${row.name}</h6><p>${row.comment}</p><small>${row.date_created.split(' ')[0]}</small></div>
          `)
        })
        if(data.data.length == 0){
          $('#comment-list').html('<h5 class="text-light">No comments posted yet</h5>')
        }
        playFunction()
      } else {
        $('#comment-list').html('<h5 class="text-light">Unexpected error fetching data</h5>')
      }
    })
    .catch(error => console.error(error));
    }

    $('#comment-form').submit((e) => {
        e.preventDefault();

        $('.alert').attr("hidden", true)

        var values = {};
        $.each($('#comment-form').serializeArray(), function(i, field) {
            values[field.name] = field.value
        })

        $('.btn').attr('disabled', true).html('Submitting...')

        fetch('<?=URL?>' + '/api/postmoviecomment', {method: 'POST', body: JSON.stringify(values) })
        .then(response => response.json())
        .then(data => {console.log(data)
            $('.alert').attr("hidden", false).html(data.message)
            $('.btn').attr('disabled', false).html('Submit')
            if(data.status) $('#comment-form').trigger('reset')
        })
        .catch(error => console.error(error));
    })


</script>