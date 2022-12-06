
<div id="main">
    <div id="content">
      <div class="box">
        <div class="head">
        </div>
        <div>
        <div class="alert alert-primary w-50" role="alert" hidden></div>
        <div><h5 class="mb-3 text-light">Create Movie</h5></div>
        <form id="create-form">
<div class="mb-2">
          <label for="name" class="form-label text-light">Name</label>
  <input type="text" class="form-control w-50" id="name" name="name" required>
</div>
<div class="mb-2">
          <label for="name" class="form-label text-light">Description</label>
  <textarea class="form-control w-50" id="description" name="description" rows="3" required></textarea>
</div>
<div class="mb-2">
          <label for="name" class="form-label text-light">Release Date</label>
  <input type="date" class="form-control w-50" id="release_date" name="release_date" required>
</div>
<div class="mb-2">
          <label for="name" class="form-label text-light">Rating</label>
          <select id="rating" name="rating" class="form-select w-50" required>
  <option selected>Select Rating</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select>
</div>
<div class="mb-2">
          <label for="name" class="form-label text-light">Ticket Price</label>
  <input type="number" class="form-control w-50" id="ticket_price" name="ticket_price" required>
</div>
<div class="mb-2">
          <label for="name" class="form-label text-light">Country</label>
  <input type="text" class="form-control w-50" id="country" name="country" required>
</div>
<div class="mb-2">
          <label for="name" class="form-label text-light">Genre</label></br>
  <input type="hidden" class="form-control w-50" id="genre" name="genre">
  <div class="form-check form-check-inline">
  <input class="form-check-input pref" type="checkbox" id="inlineCheckbox1" value="Action">
  <label class="form-check-label text-light" for="inlineCheckbox1">Action</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input pref" type="checkbox" id="inlineCheckbox2" value="Thriller">
  <label class="form-check-label text-light" for="inlineCheckbox2">Thriller</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input pref" type="checkbox" id="inlineCheckbox3" value="Horror">
  <label class="form-check-label text-light" for="inlineCheckbox3">Horror</label>
</div>
</div>
<div class="mb-2">
          <label for="name" class="form-label text-light">Photo</label>
  <input type="file" class="form-control w-50" id="photo" name="photo" required>
</div>
<button type="submit" class="btn btn-primary mt-2 w-25">Submit</button>
        </form>
        </div>
        <div class="cl">&nbsp;</div>
      </div>
    </div>
    <div class="cl">&nbsp;</div>
  </div>

  <script>
    $('#create-form').submit((e) => {
        e.preventDefault();

        $('.alert').attr("hidden", true)
        $('.btn').attr('disabled', true).html('Submittng...')

        const fileInput = document.querySelector("#photo");
        const formData = new FormData();

        formData.append("file", fileInput.files[0]);
        formData.append("token", '<?=isset($_SESSION["token"]) ? $_SESSION["token"] : ''?>')
        formData.append("name", $('#name').val())

        formData.append("description", $('#description').val())
        formData.append("release_date", $('#release_date').val())
        formData.append("rating", parseInt($('#rating').val()))
        formData.append("ticket_price", parseFloat($('#ticket_price').val()))
        formData.append("country", $('#country').val())
        formData.append("genre", $('#genre').val())

        fetch('<?=URL?>' + '/api/createmovie', {method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {console.log(data)
            $('.alert').attr("hidden", false).html(data.message)
            $('.btn').attr('disabled', false).html('Submit')

            if(data.status) $('#create-form').trigger('reset')
        })
        .catch(error => console.error(error));
    })

    $(document).ready(function() {
      $('.pref').change(function(){
        let new_val = ""
        $('.pref').each(function(index){
          if($(this).attr("checked") == true){
            new_val += $(this).attr("value")+','
          }
        })
        $('#genre').val(new_val)
      })
    })
  </script>