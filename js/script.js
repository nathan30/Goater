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

jQuery(window).load(function() {
	$(".se-pre-con").fadeOut("slow");
})



//Ajax

// Fonction d'envoi de tweet
$(function () {
    $('#form-tweet').on('submit', function (e) {
        // On empêche le navigateur de soumettre le formulaire
        e.preventDefault();

        var tweet_val = $('#tweet').val();
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

        $.post( "goater.php?action=AjaxCreateTweet", {
            tweet: tweet_val,
            success : success()
        });

        function success(){
            $(".container-goat1").hide();
            $( ".container-goat1" ).prepend(
                '<blockquote class="goat-box">'+
                    '<p class="pull-right">'+
                        '<a href="#" class="glyphicon glyphicon-trash"></a>'+
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
                                    '@'+identifiant+
                                '</a>'+
                        '</p>'+
                        '<p class="blog-post-bottom pull-right">'+
                            '<a href="#" class="like glyphicon glyphicon-heart"></a>'+
                            '<span class="badge quote-badge">0</span>'+
                        '</p>'+
                    '</div>'+
                '</blockquote>'
            );
            $(".container-goat1").slideDown();
        }
    });
});

// Fonction d'ajout/suppression de vote

$('.like').click(function (e) {
    // On empêche le navigateur d'effectuer l'action du <a>
    e.preventDefault();
    var idTweet = $(this).attr("href").match(/id=([0-9]+)/)[1];
    var action = $(this).attr("href").match(/action=([a-z]+)/)[1];
    if(action == 'add'){
        var url = 'goater.php?action=AjaxLikeTweet&id='+idTweet+'&redirect=view_profile';
        $('.like').attr("href",'goater.php?action=deleteVote&id='+idTweet+'');
    }
    else if(action == 'delete'){
        var url = 'goater.php?action=AjaxDeleteLikeTweet&id='+idTweet+'&redirect=view_profile';
        $('.like').attr("href",'goater.php?action=addVote&id='+idTweet+'');
    }
    console.log(url);
    var thislink = $(this);
    $.post( url, {
        id: idTweet,
        success : function(){
            var nbVote = $(thislink,'span').text();
            if(action == 'add'){
                $(thislink).addClass("red");
                nbVote++;
                $(thislink,'span').html("<span class='badge quote-badge'>"+nbVote+"</span></a>");
            }
            else if(action == 'delete'){
                $(thislink).removeClass("red");
                nbVote--;
                $(thislink,'span').html("<span class='badge quote-badge'>"+nbVote+"</span></a>");
            }
        }
    });
});

// Fonction de modification du profil

$(function () {
    $('#form-update').on('submit', function (e) {
        // On empêche le navigateur de soumettre le formulaire
        e.preventDefault();
        var prenom = $("#prenom").val();
        var nom = $("#nom").val();
        var statut = $("#statut").val();
        console.log(prenom);
        console.log(nom);
        console.log(statut);
        $.post( "goater.php?action=AjaxUpdateProfil", {
            edit: true,
            statut_update: statut,
            nom_update: nom,
            prenom_update: prenom,
            success : function(){
                $('#nom_prenom').html(nom+' '+prenom);
                $('#statut_form').html(statut);
                $('#form-update').hide();
                $('.bigger').addClass('col-md-offset-2 col-md-8').removeClass('col-md-6');
            }
        });
    });
});

// Fonction de suppression d'un tweet
$('.glyphicon-trash').click(function (e) {
    e.preventDefault();

    var idTweet = $(this).attr("href").match(/id=([0-9]+)/)[1];
    var thislink = $(this);
    $.post( "goater.php?action=AjaxDeleteTweet", {
        id: idTweet,
        success : function(){
            $(thislink).parent().parent().parent().slideUp();
        }
    });
});

// Fonction de vérification des nouveaux tweets
$(document).ready(function(){
    function verifNewtweet(){
        $.ajax({
            type: "POST",
            url: "goater.php?action=AjaxViewNumberNewTweet",
            dataType: 'json',
            success : function(data){
                console.log(data.new_tweet);
                if(data.new_tweet > 0){
                    if(data.new_tweet == 1) $('.new_tweet').html(data.new_tweet+' nouveau tweet').slideDown();
                    else $('.new_tweet').html(data.new_tweet+' nouveaux tweets').slideDown();
                }
            }
    });
        setTimeout(verifNewtweet,2000);
    }
    verifNewtweet();
});
