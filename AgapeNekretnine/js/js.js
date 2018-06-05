$(document).ready(function(){
    var brojac = 0;
    $("#btnDodajSliku").click(function(){
        brojac++;
        if(brojac<9999)
        $(this).before("<input type='file' size='30' id='fSlika' name='fSlika[]'/><br/>");
    });
    
    $("#chbDefault").change(function(){
        if(this.checked){
            $("#glavna_slika").addClass('hidden');
            $("#slike").addClass('hidden');
        }
        else{
            $("#glavna_slika").removeClass('hidden');
            $("#fSlikaGlavna").prop('required', true)
            $("#slike").removeClass('hidden');
            
        }
    });
});



