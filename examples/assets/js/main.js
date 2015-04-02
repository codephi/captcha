$(function () {

    $('h4', '.theme').append(" <a class=\"refresh\" title=\"Clique para atualizar a imagem\"><i class=\"glyphicon glyphicon-refresh\"></i></a>");

    $('a.refresh').click(function () {
        parent = $(this).parents('.row')[0]
        console.log(parent)
        src = $('img', parent).attr('src')
        date = new Date();
        $('img', parent).attr('src', src + '?_=' + date.getMilliseconds())
    })
})