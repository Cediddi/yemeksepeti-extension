// (c) 2015 Farhad Safarov <http://farhadsafarov.com>

var jokerNotifier = {

  _jokerUrl: 'https://www.yemeksepeti.com/basket/GetNewJokerOffer',

  checkJoker: function() {
    var _this = this;
    chrome.storage.local.get('check', function(data) {
      if (data.check) {
        _this._check();
      }
      else {
        $('.result').hide();
        $('.duration-holder').hide();
      }
    });
  },

  _check: function() {
    var _this = this,
      ysRequest = {
        'Culture': 'tr-TR',
        'LanguageId': 'tr-TR'
      };

    chrome.cookies.getAll({}, function(data) {
      $.each(data, function(index, cookie){
        switch(cookie.name) {
          case 'catalogName':
            ysRequest['CatalogName'] = cookie.value;
            break;
          case 'loginToken':
            ysRequest['Token'] = cookie.value;
            break;
        }
      });

      _this._fetchResult(ysRequest);
    });
  },

  _fetchResult: function(ysRequest) {
    var _this = this;
    $.ajax({
      url: this._jokerUrl,
      type: 'post',
      data: {
        'ysRequest': ysRequest
      },
      headers: {
        'Content-Type': 'application/json;charset=UTF-8',
        'X-Requested-With': 'XMLHttpRequest'
      },
      dataType: 'json',
      success: function (data) {
        _this.displayResult(data);
      }
    });
  },

  displayResult: function(data) {
    var resultArea = $('.result');
    resultArea.html('');

    if (data.OfferItems && data.OfferItems.length) {
      if (typeof(startTimer) === typeof(Function)) {
        startTimer(data.RemainingDuration/1000, $('#duration'));
      }

      var table = $('<table/>');

      $.each(data.OfferItems, function(index, offer) {
        var row = $('<tr/>', {
          'data-href': 'http://www.yemeksepeti.com' + offer.Restaurant.RestaurantUrl
        });

        row.append($('<td/>').html($('<img />', {
          src: 'http:'+offer.Restaurant.JokerImageUrl,
          alt: offer.Restaurant.DisplayName,
          width: 60
        })));
        row.append($('<td/>').text(offer.Restaurant.DisplayName));
        row.append($('<td/>', {'class': 'strong'}).html(offer.Restaurant.AveragePoint));
        table.append(row);
      });

      resultArea.append(table);

      chrome.browserAction.setBadgeText ( { text: data.OfferItems.length.toString() } );
    }
    else {
      // resultArea.html(data.IsValid ? 'Joker yok :(' : data.Message);
      resultArea.html('Joker yok :(');
      chrome.browserAction.setBadgeText ( { text: '' } );
    }
  }
};
