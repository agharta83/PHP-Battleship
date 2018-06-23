var app = {

  baseUrl: 'http://localhost/Galaxy/checkpoint-back-obattleship-lucie-c/',

  init: function() {
    console.log('app.init');

    //Selection de mon element #instructions
    app.$instructions = $('#instructions');

    // clic s/ nouvelle partie ==> generateMap
    $('.btn-generate').on('click', app.generateMap);

    $('.bs-case__fury').on('click', app.fire);
  },

  generateMap: function() {
    app.writeText('Génération en cours...');

    // envoyer un appel ajax à l'url baseUrl + ajax/generate
    var xhr = $.ajax(app.baseUrl + 'ajax/generate');

    // si on a un résultat, on l'affiche
    xhr.done(function(data) {
      // pour chaque case du board reçu
      for (var key in data.board) {
        // on réinitialise la case correspondante
        $('#'+key).empty()
          .removeClass('bs-case__ship');

        // s'il y a un bateau dans la case on l'écrit
        if(data.board[key] !== '') {
          $('#'+key).addClass('bs-case__ship')
            .append(data.board[key][0] + data.board[key][1]);
        }
      }
      app.writeText('A vous de tirer !!');
      app.writeText('Pour tirer cliquez sur une case dans le tableau de gauche (ou du dessus).');
    });

    // sinon, message d'erreur.
    xhr.fail(function() {
      app.writeText('Erreur lors de la génération.');
    })
  },

  fire: function() {
    app.writeText('Feu!!!');

    // la case sur laquelle on a cliqué
    var $square = $(this);

    // on va désactiver le click
    // on lui enlève sa classe fury
    $square.off('click')
      .removeClass('bs-case__fury');

    // on créer la requête ajax ver ajax/fire,
    // en joignant les coordonnées cliquées .data('coordinates')
    $.ajax({
      url: app.baseUrl + 'ajax/fire',
      method: 'POST',
      data: {'coordinates' : $square.data('coordinates')}
    })
    .done(function(data) {
      if(data.touch) {
        app.writeText('Touché!');
        $square.addClass('bs-case__fire');
      }
      else {
        app.writeText('raté!');
        $square.addClass('bs-case__empty');
      }

      // quand j'ai tiré
      // Jed emande au serveur de tirer aussi.
      app.dodge();

    })
    .fail(function() {
      app.writeText('Tir échoué, Veuillez réessayer.');
    });

  },

  dodge: function() {
    // ajax/dodge
    $.ajax(app.baseUrl + 'ajax/dodge')
      .done(function(data) {
        if(data.touch) {
          app.writeText('Vous avez touché!');
          $('#' + data.shotCoords).removeClass('bs-case__ship')
            .addClass('bs-case__ship-touch');
        }
        else {
          app.writeText('Loupé! Vous avez eu chaud ^^');
          $('#' + data.shotCoords).addClass('bs-case__empty');
        }
      })
      .fail(function() {
        app.writeText('Le serveur ne veut pas riposter :/ Shoote encore !');
      })
  },

  writeText: function(text) {

    var date = new Date();

    app.$instructions.append('<br />');
    app.$instructions.append(date.getHours()+':'+date.getMinutes()+':'+date.getSeconds()+' - '+text);
    app.$instructions.scrollTop(app.$instructions[0].scrollHeight);
  }
}

$(app.init);
