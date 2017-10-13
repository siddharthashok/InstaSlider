console.log("Sidd");

jQuery(document).ready(function($){
  // Instagram Feed
  if ( $('#instafeed').length) {

    var userFeed = new Instafeed({
        get: 'user',
        userId: instaUserID,
        accessToken: instaAccessToken,
        resolution: 'standard_resolution',
        limit: 30,
        template: '<div class="item"><a href="{{link}}" target="_blank"><img src="{{image}}"/></a></div>',
        after: function() {
          $("#instafeed").owlCarousel({
            center: true,
            items: 2,
            loop: true,
            margin: 30,
            nav:true,
            responsive: {
                0:{
                    items:2,
                    margin: 20
                },
                640: {
                    items: 4,
                }
            }
          });
        }
    });

    userFeed.run();

    // Change profile image & username of user
    $.get( fileDirectory+'/insta-api.php?user_id='+instaUserID+'&access_token='+instaAccessToken, function( data ) {
        var instaData = data;
        instaProfileImage(instaData);
    });

    function instaProfileImage(instaData) {
        $(".insta-logo img").attr("src", instaData.data.profile_picture);
        $(".insta-username").html('@'+instaData.data.username);
    }

}
});
