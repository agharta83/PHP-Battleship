var app = {

  baseUrl: 'http://localhost/xxx/yyy/',

  init: function() {
    console.log('app.init');

    //Selection de mon element #instructions
    app.$instructions = $('#instructions');
  },

  generateMap: function() {

  },

  fire: function() {

  },

  dodge: function() {

  },

  writeText: function(text) {

    var date = new Date();

    app.$instructions.append('<br />');
    app.$instructions.append(date.getHours()+':'+date.getMinutes()+':'+date.getSeconds()+' - '+text);
    app.$instructions.scrollTop(app.$instructions[0].scrollHeight);
  }
}

$(app.init);
