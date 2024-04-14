setInterval(function() {
    var gameDiv = document.querySelector('.game');
    var roomCode = gameDiv.getAttribute('data-roomCode');

    $.get('handlers/get_game_started.php?roomCode=' + roomCode, function(data) {
        console.log('Game started:', data);
        if (data) {
            $('#gameStatus').text('Host has started the game');
        }
    });
}, 5000); 