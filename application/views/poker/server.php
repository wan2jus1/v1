<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>Poker</title>
</head>
<body>
   <?php $this->load->view('poker/serveradd') ?>


    <style>.sin-pading{padding-left: 0px;padding-right: 0px;}.imagenprofile {
            width: 100px;
            height: 100px;
            border-radius: 50px;
            -moz-border-radius: 50px;
            -webkit-border-radius: 50px;
            -khtml-border-radius: 50px;
            overflow: hidden;
            float: right;
        }</style>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    var socket;
//                        guarda el idde la silla
    var idsit;
    var protocol_identifier = 'server';
    var myId;
    var idsale;
    var nicklist;
    var is_typing_indicator;
    var window_has_focus = true;
    var actual_window_title = document.title;
    var flash_title_timer;
    var connected = false;
    var connection_retry_timer;
    var server_url = 'ws://localhost:8806/';
    var token = "<?php
if (isset($_COOKIE['token'])) {
    echo $_COOKIE['token'];
} elseif ($this->session->userdata('token')) {
    echo $this->session->userdata('token');
}
?>";
    var msg_bubble_colors = [
        '#FFFFFF',
        '#E2EBC0',
        '#F3F1DC',
        '#F6E1E1',
        '#EDF9FC',
        '#EBF3EC',
        '#F4EAF1',
        '#FCF1F8',
        '#FBFAEF',
        '#EFF2FC'
    ];
    $(document).ready(function() {
        'use strict';
        //si le dan click a reconectar
        $('#buttonreconect').click(function() {
            hideConnectionLostMessage();
            connetserver();
        });
        $('#buttoncreate').click(function() {
            var namesale = $('#namesale').val();
            var clave = $('#passsale').val();
            var minapos = $('#minapos').val();
            var maxapos = $('#maxapos').val();
            var minci = $('#minci').val();
            var maxci = $('#maxci').val();
            var maxus = $('#maxus').val();
            var intro = {
                type: 'newsale',
                namesale: namesale,
                clave: clave,
                minapos: minapos,
                maxapos: maxapos,
                minci: minci,
                maxci: maxci,
                maxus: maxus
            }

            socket.send(JSON.stringify(intro));
        });
        $('#buttonsitdown').click(function() {
            var min = $('#inputapos').attr('min');
            var max = $('#inputapos').attr('max');
            var inputapos = $('#inputapos').val();
            console.log(max);
            console.log(inputapos);
            console.log(min);
            if (min <= inputapos && max >= inputapos) {

                $('#boxsitdown').slideUp();
                var intro = {
                    type: 'sitdown',
                    inputapos: inputapos,
                    idsale: idsale,
                    idsit: idsit
                }

                socket.send(JSON.stringify(intro));
            }
        });
        //boton para acceder al juego
        $('#buttonjoingame').click(function() {
            $('#passloss').slideUp();
            var passbox = $('#passbox').val();
            $('#passbox').val('');
            conexgame(passbox);
        });
        //si no soporta websocket
        if (!is_websocket_supported()) {
            $('#game').html('Your browser <strong>doesnt</strong> support '
                    + 'websockets :( <br/>Por favor cambie a otro explorador '
                    + 'a uno moderlo, sugerimos este <a href="http://www.firefox.com/">Firefox</a> '
                    + 'o <a href="http://www.google.com/chrome">Google Chrome</a>.');
        }

        connetserver();
    });
    function connetserver() {
        //muestra el tiempo de espera al servidor revisar la funcion para que cargue si no hay conexion
        // show_timer();
        //abrir la conexion
        open_connection();
    }

    function open_connection() {
        socket = new WebSocket('ws://localhost:8806/', 'server');
        socket.addEventListener("open", connection_established);
    }
    //cuando la conexion se establece
    function connection_established(event) {
        connected = true;
        //hideConnectionLostMessage();
        clearInterval(connection_retry_timer);
        introduce(token);
        socket.addEventListener('message', function(event) {
            message_received(event.data);
        });
        socket.addEventListener('close', function(event) {
            connected = false;
            showConnectionLostMessage();
            //reConnect();
        });
    }

    function introduce(nickname) {
        var intro = {
            type: 'join',
            token: nickname
        }

        socket.send(JSON.stringify(intro));
    }
    //segun el mensaje que llegue realiza un caso especifico
    function message_received(message) {
        var message;
        message = JSON.parse(message);
        //trae las salas actuales
        if (message.type === 'sales') {
            myId = message.userId;
            // $('#chat-container').fadeIn();
            //$('#loading-message').hide();
            var newvar = {};
            newvar = new Object();
            newvar = message.messagesend;
            var myObj = newvar;
            var array = $.map(myObj, function(value, index) {
                return [value];
            });
            sales(array, message.clients);
        }
        //                accede al juego para elegir una silla
        else if (message.type === 'joinsale') {
//             $('#chat-container').fadeIn();
//            $('#loading-message').hide();
            var newvar = {};
            newvar = new Object();
            newvar = message.messagesend;
            var myObj = newvar;
            console.log(myObj);
//                                if (myObj.lenght !== undefined){
            var array = $.map(myObj, function(value, index) {
                return [value];
            });
//                                }
//                                else{
//                                    var array = [];
//                                }
            console.log(array);
            gameposition(array);
//            $('#rowsales').slideUp();
            $('#rowgame').slideDown();
            // $('#chat-container').fadeIn();
            //$('#loading-message').hide();
            //$('#game').html(message.messagesend);
        }
        else if (message.type === 'numcoin') {
            $('#inputapos').attr('min', message.messagesend.apu_min);
            $('#inputapos').attr('max', message.messagesend.apu_max);
            $('#boxsitdown').slideDown();
        }
//                            /si el password es falso
        else if (message.type === 'passfalse') {

            $('#passloss').html(message.messagesend);
            $('#passloss').slideDown();
            $('#boxpass').slideDown();
        }
        //                si ya esta conectado
        else if (message.type === 'readyconect') {


            $('#user-conect').slideDown();
            // $('#chat-container').fadeIn();
            //$('#loading-message').hide();
            //$('#game').html(message.messagesend);
        }
        //para traer datos del usuarhio
        else if (message.type === 'welcome') {
            myId = message.userId;
            // $('#chat-container').fadeIn();
            //$('#loading-message').hide();
//                                console.log(message.messagesend);
            if (message.messagesend == 'aqui falso') {
                var url = "./close";
                $(location).attr("href", url);
            }
        } else if (message.type === 'message' && parseInt(message.sender) !== parseInt(myId)) {
            //add_new_msg_to_log(message);
            blink_window_title('~ message poker ~');
            //showNewMessageDesktopNotification(message.nickname, message.message);
        } else if (message.type === 'nicklist') {
            var chatter_list_html = '';
            nicklist = message.nicklist;
            for (var i in nicklist) {
                chatter_list_html += '<li>' + nicklist[i] + '</li>';
            }

            chatter_list_html = '<ul>' + chatter_list_html + '</ul>';
            $('#chatter-list').html(chatter_list_html);
        } else if (message.type === 'activity_typing' && parseInt(message.sender) !== parseInt(myId)) {
            var activity_msg = message.name + ' is typing..';
            $('#is-typig-status').html(activity_msg).fadeIn();
            clearTimeout(is_typing_indicator);
            is_typing_indicator = setTimeout(function() {
                $('#is-typig-status').fadeOut();
            }, 2000);
        }

    }

    //mensaje al perder la conexion
    function showConnectionLostMessage() {
        // $('#send-msg textarea, #send-msg span').hide();
        $('#connection-lost-message').slideDown();
    }
    //esconde el mensaje de perder conexion
    function hideConnectionLostMessage() {
        // $('#send-msg textarea, #send-msg span').hide();
        $('#connection-lost-message').slideUp();
        $('#user-conect').slideUp();
    }

    //muestra el tiempo de espera al servidor
    function show_timer() {
        if (connected == false) {
            var time_start = 5;
            var time_string;
            var connection_retry_timer = window.setInterval(function() {
                if (time_start-- > 0) {
                    time_string = time_start + ' seconds';
                } else {
                    time_string = '..ahem ahem, a little more..';
                }

                $('#game').html(time_string);
            }, 1000);
        }
    }

    //funcion para saber si funciona el websocket
    function is_websocket_supported() {
        if ('WebSocket' in window) {
            return true;
        }
        return false;
    }

    function joingame(id, pass) {
        idsale = id;
//       idsit=undefined;
        if (pass == 1) {
            $('#boxpass').slideDown();
        }
        else {
            conexgame();
        }
    }

    function conexgame(pass) {
        var intro = {
            type: 'joingame',
            idsale: idsale,
            pass: pass
        }

        socket.send(JSON.stringify(intro));
    }
    //construye la tabla

    function gameposition(arraycon) {
        var con = 0;
//                            if (arraycon.length !== undefined) {
//                                con = arraycon.length;
//                            }
        con = arraycon.length;
        for (i = 0; i < con && i < 7; i++) {
            if (arraycon[i].name == undefined) {
                elementprofile(i, undefined, arraycon[i]);
            }
            else {
                elementprofile(i, true, arraycon[i]);
            }
        }
    }
    function elementprofile(i, disponible, arraycon) {
        i++;
        var elem = "#player" + i;
        var name = elem + 'name';
        var coin = elem + 'coin';
        var time = elem + 'time';
        var apos = elem + 'apos';
        var imageprofile = elem + 'imageprofile';
        var cartas = elem + 'cartas';
        var cartasplay = elem + 'cartasplay';
        var cartasplay2 = elem + 'cartasplay2';
        if (disponible == undefined) {

            $(name).html('disponible');
            $(coin).html('');
            $(time).html('');
            $(apos).html('');
            $(imageprofile).attr('src', './imagen/poker/jugador.png');
            $(cartas).slideUp();
            $(cartasplay).slideUp();
            $(cartasplay2).slideUp();
        }
        else {
            console.log(arraycon.imageprofile);
            $(name).html(arraycon.name);
            $(coin).html(arraycon.coin);
            $(time).html('');
            $(apos).html(arraycon.apos);
            $(imageprofile).attr('src', arraycon.imageprofile);
            $(cartas).slideDown();
            $(cartasplay).slideUp();
            $(cartasplay2).slideUp();
        }
    }
    function refresh() {
        socket.close();
        $('#buttonreconect').click();
    }
//    function para ver el perfil del usuario o para sentarse en el puesto
    function seeplayer(player, idsit2) {
        idsit = idsit2;
        var elem = player;
        var name = elem + 'name';
        var disp = $(name).html();
        if (disp == "disponible") {
            var intro = {
                type: 'numcoin',
                inputapos: inputapos,
                idsale: idsale
            }
            socket.send(JSON.stringify(intro));
            $('#sitdown').slideUp();
        }
        else {
            $('#thisprofile').slideUp();
        }
    }
//                        funcion para mostrar el value al darle sentar input range
    function outputUpdate(vol) {
        document.querySelector('#volume').value = vol;
    }

</script>


</body>