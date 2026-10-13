{* @formatter:off *}{* 评论发布框（xh_002 自定义） *}
<div class="post" id="divCommentPost">
    <p class="posttop">
        <a name="comment">{if $user.ID>0}{$user.StaticName}{/if}发表评论:</a>
        <a rel="nofollow" id="cancel-reply" href="#divCommentPost" style="display:none;"><small>取消回复</small></a>
    </p>

    <form id="frmSumbit" target="_self" method="post" action="{$article.CommentPostUrl}">
        <input type="hidden" name="inpId" id="inpId" value="{$article.ID}" />
        <input type="hidden" name="inpRevID" id="inpRevID" value="0" />

{if $user.ID>0}
        <input type="hidden" name="inpName" id="inpName" value="{$user.StaticName}" />
        <input type="hidden" name="inpEmail" id="inpEmail" value="" />
        <input type="hidden" name="inpHomePage" id="inpHomePage" value="" />
{else}
        <p>
            <select id="inpNamePreset" class="text" tabindex="1" onchange="xhCommentSyncName()">
                <option value="">请选择昵称</option>
                <option value="胖达">胖达</option>
                <option value="恐龙">恐龙</option>
                <option value="顾得">顾得</option>
                <option value="丹妮">丹妮</option>
                <option value="__other__">其他</option>
            </select>
        </p>

        <p id="inpNameOtherWrap" style="display:none;">
            <input type="text" id="inpNameOther" class="text" value="" tabindex="2" placeholder="请输入你的昵称" />
        </p>

        <input type="hidden" name="inpName" id="inpName" value="" />
        <input type="hidden" name="inpEmail" id="inpEmail" value="" />
        <input type="hidden" name="inpHomePage" id="inpHomePage" value="" />
        {template:commentpost-verify}
{/if}

        <p style="display:none;"><label for="txaArticle">评论内容(*)</label></p>
        <p><textarea name="txaArticle" id="txaArticle" class="text" cols="50" rows="4" tabindex="5"></textarea></p>
        <p><input name="sumbit" type="submit" tabindex="6" value="提交" onclick="return xhCommentBeforeSubmit() && zbp.comment.post()" class="button" /></p>
    </form>
    <p class="postbottom">请文明发言，禁止发布广告或违法内容。</p>
</div>

<script>
function xhCommentSyncName() {
    var preset = document.getElementById('inpNamePreset');
    var otherWrap = document.getElementById('inpNameOtherWrap');
    var otherInput = document.getElementById('inpNameOther');
    if (!preset) return;

    var isOther = preset.value === '__other__';
    if (otherWrap) otherWrap.style.display = isOther ? 'block' : 'none';
    if (!isOther && otherInput) otherInput.value = '';
}

function xhCommentBeforeSubmit() {
    var preset = document.getElementById('inpNamePreset');
    var nameField = document.getElementById('inpName');
    var otherInput = document.getElementById('inpNameOther');

    if (!preset || !nameField) return true;

    var selected = preset.value;
    if (selected === '') {
        alert('请选择昵称');
        preset.focus();
        return false;
    }

    if (selected === '__other__') {
        var otherName = otherInput ? otherInput.value.trim() : '';
        if (!otherName) {
            alert('本汤要知道你是谁');
            if (otherInput) otherInput.focus();
            return false;
        }
        nameField.value = otherName;
        return true;
    }

    nameField.value = selected;
    return true;
}
</script>
