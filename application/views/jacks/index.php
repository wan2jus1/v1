<!DOCTYPE html>
<html>
    <head>
        <title></title> 
        <?php $this->load->view('page/header'); ?>
        <link rel="stylesheet" href="./games/game-jacks-or-better/game1024x768/css/reset.css" type="text/css">
        <link rel="stylesheet" href="./games/game-jacks-or-better/game1024x768/css/main.css" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="msapplication-tap-highlight" content="no"/>

        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/createjs-2013.12.12.min.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/ctl_utils.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/sprite_lib.js"></script>
        <!--<script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/settings.js"></script>-->
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CLang.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CPreloader.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CMain.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CTextButton.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CGfxButton.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CToggle.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CMenu.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CGame.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CInterface.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CGameSettings.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CCard.js"></script>
	    <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CGameOver.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CPayTable.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CPayTableSettings.js"></script>
        <script type="text/javascript" src="./games/game-jacks-or-better/game1024x768/js/CHandEvaluator.js"></script>
        
    </head>
    <body ondragstart="return false;" ondrop="return false;" style="  background: rgb(42, 89, 88); overflow-x:hidden;">
        <?php $this->load->view('page/navegation/header');?>
        <?php $this->load->view('page/navegation/notification');?>
    </div>
          <script>
            $(document).ready(function(){
                     var oMain = new CMain({
                                    bets: [0.2,0.3,0.5,1,2,3,5],           //ALL THE AVAILABLE BETS FOR THE PLAYER
                                    combo_prizes: [250,50,25,9,6,4,3,2,1], //WINS FOR FIRST COLUMN
                                    money: 0                          ,  //STARING CREDIT FOR THE USER
                                    recharge:true                           //RECHARGE WHEN MONEY IS ZERO. SET THIS TO FALSE TO AVOID AUTOMATIC RECHARGE
                                });


                    var socket;
                    var protocol_identifier = 'server';
                    var myId;
                    var idgame=31; //aqui debe llevarse el nombre del juego que selecciono
                    var nicklist;
                    var is_typing_indicator;
                    var window_has_focus = true;
                    var actual_window_title = document.title;
                    var flash_title_timer;
                    var connected = false;
                    var connection_retry_timer;
                    var server_url = 'ws://162.252.57.97:8082';
                    var token = "<?php
    if (isset($_COOKIE['token'])) {
        echo $_COOKIE['token'];
    } elseif ($this->session->userdata('token')) {
        echo $this->session->userdata('token');
    }
    ?>";


                     $(oMain).on("game_start", function(evt) {
                             //alert("game_start");
                            totalcoins();
                            var options = {
                                "backdrop" : "static"
                            }

                        $('#myModal').modal(options);
                     });

                     $(oMain).on("end_hand", function(evt,iMoney,iWin) {
                             //alert("iMoney: "+iMoney +" WIN: "+iWin);
                     });

                     $(oMain).on("restart", function(evt) {
                             //alert("restart");
                     });
					 
                    $(oMain).on("recharge", function(evt) {
                             //alert("recharge");
                     });

                      $('#buttonreconect').click(function() {
                    hideConnectionLostMessage();
                    connetserver();
                });
                $('#money-button').click(function() {

                var value_mt=  $('#money-text').val();
                var total_money= $('#total_coins').html();
                  //alert(total_money);
                  //alert(value_mt);
                if (value_mt>10 && value_mt < parseFloat(total_money)) {
                    // alert('llega aqui');
                    iMoney=value_mt;
                    s_oGame.TOTAL_MONEY=value_mt;
                    s_oGame._iMoney= value_mt;
                    s_oGame.moneyref(parseFloat(value_mt));

                    //  console.log('iMoney' + parseFloat(iMoney));
                   //  console.log('total Money' + TOTAL_MONEY);
                    bet = BET_TYPE[0];
                    s_oInterface.refreshMoney(parseFloat(iMoney), bet);
                    //s_oInterface.enableBetFiches();

                    var enviarm = {
                        type: 'sitmoney',
                        sitmoney: value_mt
                        }
                    socket.send(JSON.stringify(enviarm));


                    $('#myModal').modal('toggle');

                } else if (value_mt <10)
                    {
                      alert('Monto mínimo.');
                    } else
                    {
                      alert('saldo insuficiente.');
                  }
            });

                connetserver();
                function connetserver() {
                 
                  open_connection();
                }

                function open_connection() {
                   socket = new WebSocket('ws://162.252.57.97:8085/', 'server');
                   //socket = new WebSocket('ws://localhost:8082/', 'server');
                    socket.addEventListener("open", connection_established);
                }
              //cuando la conexion se establece
                function connection_established(event) {
                    connected = true;
                      //hideConnectionLostMessage();
                    clearInterval(connection_retry_timer);
                     // alert(token);
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
                function introduce(nickname) {
                      var intro = {
                          type: 'join',
                          token: nickname,
                          idgame: idgame
                      }

                    socket.send(JSON.stringify(intro));
                }
                  function is_websocket_supported() {
                      if ('WebSocket' in window) {
                          return true;
                      }
                      return false;
                  }

                message_received= function(message) {
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
                          //sales(array, message.clients);
                    }else if (message.type === 'money_total') { //si ya esta conectado

                      myId = message.userId;

                      var  coinsvar = message.messagesend;
                      coinslabel(coinsvar);

                    }else if (message.type === 'handreturnindex') {
                    myId = message.userId;
                    var newvar = message.messagesend;
                    //console.log('arreglo recibido'+newvar);
                    s_oGame.indexnodereturn(newvar);

                    }else if (message.type === 'handreturn') {
                    myId = message.userId;
                    var newvar = message.messagesend;
                    //console.log('arreglo mano recibido'+newvar +  'tiene posiciones'+newvar.length);

                    s_oGame.handnodereturn(newvar);
                    
                    }else if (message.type === 'drawreturn') {
                    myId = message.userId;
                    var newvar = message.messagesend;
                    //console.log('arreglo mano recibido'+newvar +  'tiene posiciones'+newvar.length);

                    s_oGame.drawnodereturn(newvar);
                    }else if (message.type === 'readyconect') {
                        $('#user-conect').slideDown();
                      // $('#chat-container').fadeIn();
                      //$('#loading-message').hide();
                      //$('#game').html(message.messagesend);
                    }else if (message.type === 'welcome') {//para traer datos del usuarhio
                      myId = message.userId;
                      // $('#chat-container').fadeIn();
                      //$('#loading-message').hide();
                      //console.log(message.messagesend);
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
           
                /*dealcards_node = function(e){
                //public function prueba(){
                    e.type='dealcards';
                    //alert(enviar.type);
                    socket.send(JSON.stringify(e));
                }*/
                createcards_node = function(e){
                //public function prueba(){
                    e.type='createcards';
                    //alert(enviar.type);
                    socket.send(JSON.stringify(e));
                }
                checkhandeal_node = function(e){
                //public function prueba(){
                    e.type='checkhandeal';
                    //alert(enviar.type);
                    //console.log('asdsadads'+JSON.stringify(e));
                    socket.send(JSON.stringify(e));
                }
                cambiarinfo_node = function(enviar){
                //public function prueba(){
                    enviar.type='cambiarinfo';
                    //alert(enviar.type);
                    //console.log('JSON.stringify(enviar)'+ JSON.stringify(enviar));
                    socket.send(JSON.stringify(enviar));
                }
                function totalcoins(){

                    var money_total = {

                      type: 'money_ws'
                    }

                    //alert(enviar.type);

                    socket.send(JSON.stringify(money_total));
                }

            function coinslabel(coins){

                 //   alert(coins);
                //$('#money-hidden').val(coins);
                 $('#total_coins').html(coins);
                 
            }

           });

        </script>
    <div id ="videopoker" class="container-fluid sin-padding">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sin-padding">
                <div class="content-canvas">
                    <canvas id="canvas" class='ani_hack' width="1024" height="768"> </canvas>
                </div>  
            </div>
        </div>
    

 <button style="display: none;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Cargar Saldo</button>

        
        <!-- Modal -->
         <div class="modal fade box-cargar-saldo" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content firstmodal">
                    <div class="modal-header">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="saldo-carga">
                                    <div class="col-xs-4">
                                    <p class="ficha">Fichas Disponibles:</p> 
                                        <div class="mount">
                                            <p><label id="total_coins"></label></p>
                                        </div>
                                    </div> 
                                <div class="col-xs-6 ">
                                    <p class="ficha">Ingrese el monto de fichas:</p> 
                                        <!--<label >Cargar Saldo: </label>-->
                                        <!--     <input type="hidden" name="money-hidden" id="money-hidden" name="money-hidden"> -->
                                        <input type="numeric" name="money-text" id="money-text" maxlength="5" class="money-text" title="0" placeholder="Fichas a recargar">
                                        <button type="button" class="btn btn-default btn-submit"  id="money-button">Aceptar</button>
                                    </div>    
                                </div>    
                                </div>
                            </div>
                                
                                
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer"> 
                         <!-- Casino4as: Recuerda siempre cerrar sesion si no estas jugando en una maquina de confianza. -->
                         <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> 
                    </div>
                </div>

            </div>
        </div>
</div>
<?php $this->load->view('page/footer'); ?>
    
    </body>

</html>