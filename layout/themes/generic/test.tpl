<!DOCTYPE html>
<html lang="{$this->html->getLocale()->language}">
    <head>
        {$this->html->meta->generic()}
        {$this->html->getCSS(array('css/bootstrap/css/bootstrap.min.css'))}
        {$this->html->getJS(array('js/jquery.libs.min.js'))}
        {$this->html->getJS(array('js/dadiweb.js'))}
        <script type="text/javascript">
            Dadiweb.baseUrl='{$this->baseUrl}';
            Dadiweb.designUrl='{$this->designUrl}';
            Dadiweb.dataUrl='{$this->dataUrl}';
            Dadiweb.localeCurrent='{$this->html->getLocale()->original}';
            Dadiweb.localeDefault='{$this->html->getDefaultLocale()->original}';
        </script>
        {$this->html->getActionJS()}
        {$this->html->getActionCSS()}
    </head>
    <body>
        <div class="container">
            {$this->render('/test/index/index/test/2')}
            {$content}
        </div>
    </body>
</html>