var CANVAS_WIDTH = 1024;
var CANVAS_HEIGHT = 768;

var FPS_TIME      = 1000/24;
var DISABLE_SOUND_MOBILE = true;

var STATE_LOADING = 0;
var STATE_MENU    = 1;
var STATE_HELP    = 1;
var STATE_GAME    = 3;

var STATE_GAME_WAITING_FOR_BET    = 0;
var STATE_GAME_DEALING            = 1;
var STATE_GAME_HITTING            = 2;
var STATE_GAME_SPLIT              = 3;
var STATE_GAME_FINALIZE           = 4;
var STATE_GAME_SHOW_WINNER        = 5;

var STATE_CARD_DEALING  = 0;
var STATE_CARD_SPLIT    = 1;
var STATE_CARD_REMOVING = 2;

var ON_MOUSE_DOWN  = 0;
var ON_MOUSE_UP    = 1;
var ON_MOUSE_OVER  = 2;
var ON_MOUSE_OUT   = 3;
var ON_DRAG_START  = 4;
var ON_DRAG_END    = 5;

var SIT_DOWN = "SIT_DOWN";
var PASS_TURN = "PASS_TURN";
var PLAYER_LOSE = "PLAYER_LOSE";
var ASSIGN_FICHES = "ASSIGN_FICHES";
var FICHES_END_MOV = "FICHES_END_MOV";
var RESTORE_ACTION = "RESTORE_ACTION";
var END_HAND = "END_HAND";
var ON_CARD_SHOWN = "ON_CARD_SHOWN";
var ON_CARD_ANIMATION_ENDING = "ON_CARD_ANIMATION_ENDING";
var SPLIT_CARD_END_ANIM = "SPLIT_CARD_END_ANIM";
var ON_CARD_TO_REMOVE = "ON_CARD_TO_REMOVE";

var NUM_FICHES = 6;
var CARD_WIDTH = 44;
var CARD_HEIGHT = 63;
var MIN_BET;
var MAX_BET;
var TOTAL_MONEY;
var FICHE_WIDTH;
var TIME_FICHES_MOV = 600;
var TIME_CARD_DEALING = 250;
var TIME_CARD_REMOVE = 1000;
var TIME_SHOW_FINAL_CARDS = 4000;
var TIME_END_HAND = 1500;
var BET_TIME = 10000;