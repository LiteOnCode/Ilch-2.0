<form class="form-horizontal" id="downloadsForm" method="POST" action="<?=$this->getUrl(['action' => $this->getRequest()->getActionName()]); ?>">
    <?=$this->getTokenField(); ?>
    <table class="table table-hover table-striped">
        <colgroup>
            <col class="icon_width" />
            <col class="icon_width" />
            <col class="icon_width" />
            <col />
        </colgroup>
        <thead>
            <tr>
                <th><?=$this->getCheckAllCheckbox('check_users') ?></th>
                <th></th>
                <th></th>
                <th><?=$this->getTrans('profileFieldName') ?></th>
            </tr>
        </thead>
        <tbody id="sortable">
            <?php
            $profileFields = $this->get('profileFields');

            foreach ($profileFields as $profileField) :
            ?>
            <tr id="<?=$profileField->getId() ?>">
                <td>
                    <input value="<?=$profileField->getId()?>" type="checkbox" name="check_users[]" />
                </td>
                <td>
                    <?=$this->getEditIcon(['action' => 'treat', 'id' => $profileField->getId()]) ?>
                </td>
                <td>
                    <?=$this->getDeleteIcon(['action' => 'delete', 'id' => $profileField->getId()]) ?>
                </td>
                <?php if(!$profileField->getType()) : ?>
                    <td><?=$this->escape($profileField->getName()) ?></td>
                <?php else : ?>
                    <td><b><?=$this->escape($profileField->getName()) ?></b></td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <input type="hidden" id="hiddenMenu" name="hiddenMenu" value="" />
    <?=$this->getSaveBar('saveButton')?>
</form>

<script>
$(function() {
$( "#sortable" ).sortable();
$( "#sortable" ).disableSelection();
});

$('#downloadsForm').submit (
    function () {
        var items = $("#sortable tr");

        var linkIDs = [items.size()];
        var index = 0;

        items.each(
            function(intIndex) {
                linkIDs[index] = $(this).attr("id");
                index++;
            });

        $('#hiddenMenu').val(linkIDs.join(","));
    }
);
</script>