


$(document).ready(function () {
    /*
     *réponse à un commentaire
     */
    
    $('.reply').click(function (e) {
        e.preventDefault();
        var $form = $('#form-comment');
        var $this = $(this);
        var parent_id = $this.data('id');
        var $comment = $('#comment-' + parent_id);

        $comment.after($form);
        $form.find('h4').text('Répondre à ce commentaire');
        $('#parent_id').val(parent_id);
        $comment.after($form)
    })


    /*
    *pagination
    */
    var $cPage =$('#cPage').val();
    var $nbPage =$('#nbPage').val();
    var options = {
        currentPage: $cPage,
       numberOfPages: 8,
        totalPages: $nbPage,
        itemContainerClass: function (type, page, current) {
            return (page === current) ? "active" : "pointer-cursor";
        },
        useBootstrapTooltip:true,
        onPageClicked: function(e,originalEvent,type,page){
            $('#selPage').val(page);
            $('#formPaging').submit();
        }
    }
    $('#paging').bootstrapPaginator(options);


})

$('.delet').click(function() {

    if(confirm("Etes-vous sur de vouloir  supprimer ?")) document.location.href = url;

    return false;

} );


tinymce.init({ selector:'textarea#editable',
    language: 'fr_FR',
    entity_encoding : "raw"

});