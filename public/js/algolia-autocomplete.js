$(document).ready(function() {
    $('.js-search-autocomplete').each(function() {
        /* Get the data from SearchByTagSpeakerType */
        let autocompleteUrlTag = $(this).data('tag-url');
        let autocompleteUrlSpeaker = $(this).data('speaker-url')
        $(this).autocomplete({hint: false}, [
            {
                /* Autocomplete the tags and display the tag.name*/
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
                /* Autocomplete the speakers and display the speaker.name */
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