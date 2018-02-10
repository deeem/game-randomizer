new Vue({
  el: '#randomizer',
  data: {
    platform_id: null,
    games: [],
  },
  mounted() {
    this.platform_id = platform_id;
    axios.get('/randomize/' + platform_id).then(response => this.games = response.data);
  },
  computed: {
    availableGames: function() {
      return this.games.filter(function(item) {
        return item.enabled;
      });
    }
  },
  methods: {
    roll: function() {

      enabledGames = this.games.filter(function(item) {
        return item.enabled;
      });

      randomGame = Math.floor(Math.random() * enabledGames.length);

      enabledGames[randomGame].enabled = false;
      enabledGames[randomGame].class = 'randomizer-item-disabled';
    }
  }
});
