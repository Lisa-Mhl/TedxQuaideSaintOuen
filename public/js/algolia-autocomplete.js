$(document).ready(function() {
    $('.js-search-autocomplete').each(function() {
        let autocompleteUrlTag = $(this).data('tag-url');
        let autocompleteUrlSpeaker = $(this).data('speaker-url')
        $(this).autocomplete({hint: false}, [
            {
                source: function(query, cb) {
                    $.ajax({
                        url: autocompleteUrlTag+'?query='+query
                    }).then(function(data) {
                        cb(data.tags);
                    });
                },
                displayKey: 'name'
            },
            {
                source: function(query, cb) {
                    $.ajax({
                        url: autocompleteUrlSpeaker+'?query='+query
                    }).then(function(data) {
                        cb(data.speakers);
                    });
                },
                displayKey: 'name'
            }
        ])
    });
});