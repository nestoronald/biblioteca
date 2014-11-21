{extends file="admin.tpl"}
{block name=title_pag}Editar {$id}
<script>xajax_editBook({$id},1);
</script>{/block}