<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>Poker</title>
</head>
<body>
    <?php $this->load->view('poker/serveradd'); ?>


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
    var pote;
    var idsit;
    var enespera;
    var sitenespera;
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
//    var server_url = 'ws://162.252.57.97:8807/';
    var serverc_url = 'ws://localhost:8806/';
    var card2 = new Array("02tre"
            , "03tre",
            '04tre',
            "05tre",
            "06tre",
            "07tre",
            "08tre",
            "09tre",
            "10tre",
            "11tre",
            "12tre",
            "13tre",
            "14tre",
            "02pic",
            "03pic",
            "04pic",
            "05pic",
            "06pic",
            "07pic",
            "08pic",
            "09pic",
            "10pic",
            "11pic",
            "12pic",
            "13pic",
            "14pic",
            "02dia",
            "03dia",
            "04dia",
            "05dia",
            "06dia",
            "07dia",
            "08dia",
            "09dia",
            "10dia",
            "11dia",
            "12dia",
            "13dia",
            "14dia",
            "02co",
            "03co",
            "04co",
            "05co",
            "06co",
            "07co",
            "08co",
            "09co",
            "10co",
            "11co",
            "12co",
            "13co",
            "14co"
            );
    var card = [];

    //trebol

    card["02tre"] = {'image': '2tre.png', 'carpeta': 'trebol'};
    card["03tre"] = {'image': '3tre.png', 'carpeta': 'trebol'};
    card["04tre"] = {'image': '4tre.png', 'carpeta': 'trebol'};
    card["05tre"] = {'image': '5tre.png', 'carpeta': 'trebol'};
    card["06tre"] = {'image': '6tre.png', 'carpeta': 'trebol'};
    card["07tre"] = {'image': '7tre.png', 'carpeta': 'trebol'};
    card["08tre"] = {'image': '8tre.png', 'carpeta': 'trebol'};
    card["09tre"] = {'image': '9tre.png', 'carpeta': 'trebol'};
    card["10tre"] = {'image': '10tre.png', 'carpeta': 'trebol'};
    card["11tre"] = {'image': 'jtre.png', 'carpeta': 'trebol'};
    card["12tre"] = {'image': 'qtre.png', 'carpeta': 'trebol'};
    card["13tre"] = {'image': 'ktre.png', 'carpeta': 'trebol'};
    card["14tre"] = {'image': 'as.png', 'carpeta': 'trebol'};
    //trebol
    card["02pic"] = {'image': '2pic.png', 'carpeta': 'pica'};
    card["03pic"] = {'image': '3pic.png', 'carpeta': 'pica'};
    card["04pic"] = {'image': '4pic.png', 'carpeta': 'pica'};
    card["05pic"] = {'image': '5pic.png', 'carpeta': 'pica'};
    card["06pic"] = {'image': '6pic.png', 'carpeta': 'pica'};
    card["07pic"] = {'image': '7pic.png', 'carpeta': 'pica'};
    card["08pic"] = {'image': '8pic.png', 'carpeta': 'pica'};
    card["09pic"] = {'image': '9pic.png', 'carpeta': 'pica'};
    card["10pic"] = {'image': '10pic.png', 'carpeta': 'pica'};
    card["11pic"] = {'image': 'jpic.png', 'carpeta': 'pica'};
    card["12pic"] = {'image': 'qpic.png', 'carpeta': 'pica'};
    card["13pic"] = {'image': 'kpic.png', 'carpeta': 'pica'};
    card["14pic"] = {'image': 'as.png', 'carpeta': 'pica'};

    //diamante
    card["02dia"] = {'image': '2dia.png', 'carpeta': 'diamante'};
    card["03dia"] = {'image': '3dia.png', 'carpeta': 'diamante'};
    card["04dia"] = {'image': '4dia.png', 'carpeta': 'diamante'};
    card["05dia"] = {'image': '5dia.png', 'carpeta': 'diamante'};
    card["06dia"] = {'image': '6dia.png', 'carpeta': 'diamante'};
    card["07dia"] = {'image': '7dia.png', 'carpeta': 'diamante'};
    card["08dia"] = {'image': '8dia.png', 'carpeta': 'diamante'};
    card["09dia"] = {'image': '9dia.png', 'carpeta': 'diamante'};
    card["10dia"] = {'image': '10dia.png', 'carpeta': 'diamante'};
    card["101dia"] = {'image': 'jdia.png', 'carpeta': 'diamante'};
    card["12dia"] = {'image': 'qdia.png', 'carpeta': 'diamante'};
    card["13dia"] = {'image': 'kdia.png', 'carpeta': 'diamante'};
    card["14dia"] = {'image': 'as.png', 'carpeta': 'diamante'};
    //corazon
    card["02co"] = {'image': '2co.png', 'carpeta': 'corazon'};
    card["03co"] = {'image': '3co.png', 'carpeta': 'corazon'};
    card["04co"] = {'image': '4co.png', 'carpeta': 'corazon'};
    card["05co"] = {'image': '5co.png', 'carpeta': 'corazon'};
    card["06co"] = {'image': '6co.png', 'carpeta': 'corazon'};
    card["07co"] = {'image': '7co.png', 'carpeta': 'corazon'};
    card["08co"] = {'image': '8co.png', 'carpeta': 'corazon'};
    card["09co"] = {'image': '9co.png', 'carpeta': 'corazon'};
    card["10co"] = {'image': '10co.png', 'carpeta': 'corazon'};
    card["11co"] = {'image': 'jco.png', 'carpeta': 'corazon'};
    card["12co"] = {'image': 'qco.png', 'carpeta': 'corazon'};
    card["13co"] = {'image': 'kco.png', 'carpeta': 'corazon'};
    card["14co"] = {'image': 'as2.png', 'carpeta': 'corazon'};
    var pos = [1, 2, 4, 7, 6, 5, 3];
//   console.log(card2.sort(function() {return Math.random() - 0.5}));
//   console.log(card2.length);
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
    Number.prototype.format = function(n, x, s, c) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                num = this.toFixed(Math.max(0, ~~n));
        return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
    };
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
            $('.sidebar-game').addClass('jugando');
            if (min <= inputapos && max >= inputapos) {

                $('#boxsitdown').slideUp();
                var intro = {
                    type: 'sitdown',
                    inputapos: inputapos,
                    idsale: idsale,
                    idsit: idsit
                }
                if (idsit < 6 & idsit >= 0) {
                    console.log('puesto ' + idsit);
                    $('.sit-' + idsit).removeClass('disponible');
                }

                socket.send(JSON.stringify(intro));
            }
        });
        //boton para acceder al juego
        $('#apost-mont').keyup(function() {
            $('#apost-toal').val($('#apost-mont').val());
            apostresume()
        });

        $('#exitgame').click(function() {
            var intro = {
                type: 'exitgame'
            }
            $('.mesaplayer' + (idsit + 1)).addClass('oculto');
            socket.send(JSON.stringify(intro));
            $('#rowgame').slideUp();
            $('#sales').removeClass('sales-close');
            $('#playerdata').slideDown();
            $('#playeroption').slideUp();
            $('.pote').html('0');
        });
        $('#newcomentglobal').keypress(function(e) {
            if (e.which == 13) {
                if ($('#newcomentglobal').val() !== "") {
                    var intro = {
                        type: 'comentglobal',
                        text: $('#newcomentglobal').val()
                    }
                    socket.send(JSON.stringify(intro));
                    text: $('#newcomentglobal').val('');
                } else {
                    $('#newcomentglobal').focus();
                }
            }
        });
        $('#comentglobal').click(function() {
            if ($('#newcomentglobal').val() !== "") {
                var intro = {
                    type: 'comentglobal',
                    text: $('#newcomentglobal').val()
                }
                socket.send(JSON.stringify(intro));
                text: $('#newcomentglobal').val('');
            } else {
                $('#newcomentglobal').focus();
            }
        });
        $('#buttonjoingame').click(function() {
            $('#passloss').slideUp();
            var passbox = $('#passbox').val();
            $('#passbox').val('');
            conexgame(passbox);
        });
        $('#apost').click(function() {
            var intro = {
                type: 'apost',
                montapost: $('#apost-toal').val()
            }
            socket.send(JSON.stringify(intro));
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
    function justNumbers(e) {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
            return true;
        return /\d/.test(String.fromCharCode(keynum));
    }
    function apostresume() {
        $('.apost-resume').html('Bs. ' + parseFloat($('#apost-toal').val()).format(2, 3, '.', ','));
    }
    function connetserver() {
        //muestra el tiempo de espera al servidor revisar la funcion para que cargue si no hay conexion         // show_timer();
        //abrir la conexion
        open_connection();
    }

    function open_connection() {
        //        socket = new WebSocket('ws://162.252.57.97:8807/', 'server');
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
            console.log('aqui');
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
            gameposition(array);
            //            $('#rowsales').slideUp();
            $('#rowgame').slideDown();
            // $('#chat-container').fadeIn();
            //$('#loading-message').hide();
            //$('#game').html(message.messagesend);
        }
        else if (message.type === 'card1') {
            var card3 = card[message.messagesend];
            console.log(card3);
            var url = "./imagen/poker/" + card3['carpeta'] + "/" + card3['image'];
            var img = "<img src='" + url + "' style='width:40px;height:70px;' />";
            var puesto = idsit + 1;
            var player = ".player" + puesto + "carta1";
            $(player).html(img);
        }
        else if (message.type === 'card2') {
            var card3 = card[message.messagesend];
            var url = "./imagen/poker/" + card3['carpeta'] + "/" + card3['image'];
            var img = "<img src='" + url + "' style='width:40px;height:70px;' />";
            var puesto = idsit + 1;
            var player = ".player" + puesto + "carta2";
            $(player).html(img);
        }
        else if (message.type === 'enespera') {
            console.log(message.messagesend);
            clearInterval(enespera);
            var player1 = "#player" + sitenespera + 'time';
            $(player1).html('');
            sitenespera = message.messagesend+1;
            console.log(sitenespera);
            var player = "#player" + sitenespera + 'time';
            console.log(player);
            $(player).html('20');
            if (idsit !== (sitenespera-1)) {
                //                console.log('if: ' + idsit)
                $('#playerdata').slideDown();
                $('#playeroption').slideUp();
            } else {
                //                console.log('else: ' + idsit)
                $('#playerdata').slideUp();
                $('#playeroption').slideDown();
            }
            enespera = setInterval(function() {
                myTimer();
            }, 1000);
        }
        else if (message.type === 'diler') {
            console.log('diler');
            console.log(message.messagesend);
        }
        else if (message.type === 'ciegamin') {
            console.log('ciegamin');
            console.log(message.messagesend);
        }
        else if (message.type === 'ciegamax') {
            console.log('ciegamax');

            console.log(message);
        }
        else if (message.type === 'pote') {
            pote = message.messagesend;
            $('.pote').html(message.messagesend);
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
        else if (message.type === 'alert') {
            alert(message.messagesend);
        }
        //para traer datos del usuarhio
        else if (message.type === 'comentglobal') {
            //            console.log(message.messagesend);
            var dt = message.messagesend;
            var yo = $('.sidebar-game .nameprofile').html();
            if (yo !== (dt.first_name + ' ' + dt.last_name)) {
                var cls = 'responder';
            } else {
                var cls = '';
            }
//            console.log()
            $('#globalchat').append('<div class="message"><p><span class="name ' + cls + '"> ' + dt.first_name + ' ' + dt.last_name + ' : </span>' + dt.mensaje + '</p></div>');
            $('#globalchat').scrollTop(9999999999999999999999);

        }
        else if (message.type === 'welcome') {
            myId = message.userId;
            var datos = message.messagesend[0];
            console.log(datos);
            $('.profile img').attr('src', datos.imageprofile);
            $('.sidebar-game .saldo').html('$ ' + datos.coins);
            $('.sidebar-game .nameprofile').html(datos.first_name + ' ' + datos.last_name);
            //            $('.profile img').html('<img src="' + datos[0].imageprofile + '">');
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

    function myTimer() {
//        console.log(pos[sitenespera]);
//        console.log(sitenespera);
        var player1 = "#player" + sitenespera + 'time';
        var time = parseInt($(player1).html()) - 1;
        if (time < 0) {
            clearInterval(enespera);
            $(player1).html('');
        } else {
            $(player1).html(time);
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
        $('#sales').addClass('sales-close');
        $('.create-salas').slideUp();

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
        var con = 0; //                            if (arraycon.length !== undefined) {
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
        var mesaplayer = '.mesaplayer' + i;
        if (disponible == undefined) {

            $(elem).addClass('disponible');
            $(name).html('disponible');
            $(coin).html('');
            $(time).html('');
            $(apos).html('');
            $(imageprofile).attr('src', './imagen/poker/jugador.png');
            $(cartas).slideUp();
            $(cartasplay).slideUp();
            $(cartasplay2).slideUp();
            $(mesaplayer).addClass('oculto');
        }
        else {
            //            console.log(arraycon.imageprofile);
            $(elem).removeClass('disponible');
            $(name).html(arraycon.name);
            $(coin).html(arraycon.coin);
            $(time).html('');
            $(apos).html(arraycon.apos);
            $(imageprofile).attr('src', arraycon.imageprofile);
            $(cartas).slideDown();
            $(cartasplay).slideUp();
            $(cartasplay2).slideUp();
            $(mesaplayer).removeClass('oculto');
        }
    }
    function refresh() {
        socket.close();
        $('#buttonreconect').click();
    }
    //    function para ver el perfil del usuario o para sentarse en el puesto
    function seeplayer(player, idsit2) {
        $('#torbo').slideDown();
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