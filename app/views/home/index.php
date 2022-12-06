
<div id="main">
    <div id="content">
      <div class="box">
        <div class="head">
        </div>
        <div id="movie-list"><div class="loader"></div></div>
        <div class="cl">&nbsp;</div>
      </div>
    </div>
    <div class="cl">&nbsp;</div>
  </div>
  <script>
    fetch('<?=URL?>' + '/api/getallmovies')
    .then(response => response.json())
    .then(data => {
      $('.loader').remove()
      if(data.status){
        data.data.map((row, index) => {
          $('#movie-list').append(`
          <a href="<?=URL?>/movies/${row.slug}">
          <div class="movie ${index%5 == 0 ? (index == 0 ? 'mg-14' : '') : 'mg-14'}">
          <div class="movie-image"> <span class="play"><span class="name">${row.name}</span></span><img src="${row.photo}" alt="" /> </div>
          <div class="rating">
            <p>${row.name}</p>
            <div class="stars">
              <div class="stars-in"> </div>
            </div>
            </div>
        </div>
        </a>
          `)
        })
        if(data.data.length == 0){
          $('#movie-list').html('<h5 class="text-light" style="margin: auto">No movies posted yet</h5>')
        }
        playFunction()
      } else {
        $('#movie-list').html('<h5 class="text-light" style="margin: auto">Unexpected error fetching data</h5>')
      }
    })
    .catch(error => console.error(error));
</script>
  