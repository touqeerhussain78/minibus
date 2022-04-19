@extends('layouts.user')
@section('title','Message')
@section('content')

<section class="contact-us p-100">

    <div class="container">
        <h2>Chat</h2>
        <br/>
        <div id="chat"></div>
       
    </div>
    
</section>

@endsection

@section('js')

<script uid="{{ Auth::user()->uuid }}" src="https://dev28.onlinetestingserver.com/soachatcentralizedWeb/js/ocs.js"></script>
<script type="text/javascript">
        $(function() {
             // Allow window to listen for a postMessage
            window.addEventListener("message", (event)=>{
                 $.ajax({
                    async: true,
                    url:"/operators/update-notification-count",
                    type: 'POST',
                    data:{receipant_id : event.data.recipiant_id, init : 0},
                    headers:
                        {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    success: function(data){
                    }
                });
                
                // axios.post('update-notification-count',{ receipant_id : event.data.recipiant_id, init : 0,});
                this.init = 0;
            });
            
          ocs.init({
                appid: '6917690cc216e71c0b193a55730d482c',
                appkey: '6494228cf3047c9911551977fdde652b',
                domain: 'minibus.com',
                global: '0',
                id: "{{ auth()->user()->uuid }}", 
                toid: '', // will be given when you want one to one chat
                colorScheme: 'f7941e',
                onlyAudio: 0, // will be given if you need audio chat
                element: '#chat',
          });
    
        });
</script>

@endsection