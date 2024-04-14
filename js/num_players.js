setInterval(function() {
    var gameDiv = document.querySelector('.game');
    var roomCode = gameDiv.getAttribute('data-roomCode');
    var expectedPlayers = parseInt(gameDiv.getAttribute('data-expectedPlayers'));

    $.get('handlers/get_num_players.php?roomCode=' + roomCode, function(data) {
        $('#numPlayers').text(data);
        var currentNumPlayers = parseInt(data);
        var showNamesButton = document.querySelector('button[name="showNames"]');
        if (showNamesButton) {
            showNamesButton.disabled = currentNumPlayers < expectedPlayers;
        }
    });
}, 5000);  // Refresh every 5 seconds