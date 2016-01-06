$(function(){
    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
});


//Ajax

function getTweetValue(){
    var tweet_val = $('textarea').val();
    var identifiant = $('.identifiant').val();
    var nom = $('.nom').val();
    var prenom = $('.prenom').val();
    var id_tweet = $('.id_tweet').val();
    var avatar = $('.avatar').val();
    var d = new Date();
    var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    var daynumber = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
    var hours = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","14","15","16","17","18","19","20","21","22","23","24"];
    var minutes = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30",
                   "31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60"];
    $( ".container-goat" ).prepend(
        '<blockquote class="goat-box">'+
            '<p class="pull-right">'+
                '<a href="" class="glyphicon glyphicon-trash"></a>'+
            '</p>'+
            '<div class="goat-post">'+
                '<p class="goat-text">'+
                    tweet_val +
                    '<a href="#" class="goat-time">'+days[d.getDay()]+' '+daynumber[d.getDate()-1]+' '+months[d.getMonth()]+' '+hours[d.getHours()-1]+':'+minutes[d.getMinutes()-1]+'</a>'+
                '</p>'+
            '</div>'+
            '<hr>'+
            '<div class="blog-post-actions">'+
                '<div class="user">'+
                    '<img src="'+avatar+'"class="img-responsive">'+
                '</div>'+
                '<p class="goat-author blog-post-bottom pull-left">'+
                    prenom+' '+nom +' '+
                        '<a href="?action=view_profile&pseudo='+identifiant+'" target="_blank">'+
                            identifiant+
                        '</a>'+
                '</p>'+
                '<p class="blog-post-bottom pull-right">'+
                    '<a href="" class="like glyphicon glyphicon-heart"></a>'+
                    '<span class="badge quote-badge">0</span>'+
                '</p>'+
            '</div>'+
        '</blockquote>'
    );

    $.ajax({
        url: "goater.php?action=AjaxCreateTweet",
        type: "POST",
        data: {tweet: tweet_val},
        success: success()
    });
    return false;
}

function success(){
    console.log('ok');
}
