
<div class="container">
    <h3>URLの登録に失敗しました</h3>
    <p>そのURLは既に登録されている可能性があります。</p>
    
    <br>
    <a href="/">->トップへ戻る</a>
    <br>
</div>

<?php
if (Configure::read('debug') > 1):
	echo $this->element('exception_stack_trace');
endif;
?>
