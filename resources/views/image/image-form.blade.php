@extends('layouts.app')

@section('content')
<script>var base_url = "<?= $url; ?>" </script>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Crear imagen</div>

                <div class="card-body">
                    <form method="POST" action="{{ config('app.url')}}/phrases" id="form">

                        <div class="form-group row">
                            <div class="mb-3">
                                <p class="fw-bolder">Inserte Frase </p>
                                <textarea class="form-control" id="phrase" name="phrase" rows="3" maxlength="32"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <p class="fw-bolder">Imagen de fondo</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="input-group">
                                <input type="file" class="form-control" id="background" name="background" aria-describedby="background1" accept="image/png, image/jpeg" aria-label="Upload">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="fw-bolder">Avatar</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="input-group">
                                <input type="file" class="form-control" accept="image/png, image/jpeg" id="avatar" name="avatar" aria-describedby="avatar1" aria-label="Upload">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <p></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Generar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="template">
            <div class="card">
                <div class="card-header">Template</div>
                <div class="card-body">
                <div class="row">
                        <div class="col">
                        <p class="fw-bolder">Selecciona el tamaño que deseas...</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                           <a id="tamplate1" class="btn btn-outline-success">720x480</a>
                           <a id="tamplate2" class="btn btn-outline-success">1280x720</a>
                           <a id="tamplate3" class="btn btn-outline-success">1920x1080</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #template{display:none;}
    </style>
<script>
    document.getElementById('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el envío del formulario de forma convencional

    var formData = new FormData(this); // Crea un objeto FormData con los datos del formulario
    var button1 = document.getElementById('tamplate1');
    var button2 = document.getElementById('tamplate2');
    var button3 = document.getElementById('tamplate3');
    console.log(button1,button2,button3);
    // Realiza la petición AJAX
    fetch("{{ config('app.url')}}/phrases", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Agrega el token CSRF para protección contra CSRF
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      // Maneja la respuesta del servidor
        console.log(data.images);
        document.getElementById('template').style.display = 'block';
        //720x480
        
        button1.setAttribute('href', base_url + data.images.image1);
        button1.setAttribute('target', '_blank');
        // 1280x720
        
        button2.setAttribute('href', base_url + data.images.image2);
        button2.setAttribute('target', '_blank');
        //1920x1080
        
        button3.setAttribute('href', base_url + data.images.image3);
        button3.setAttribute('target', '_blank');
    })
    .catch(error => {
      // Maneja los errores de la petición
      console.error('Error:', error);
    });
  });
</script>


@endsection

