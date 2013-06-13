{if !$ajax}
{$this->forms('add')->open()}
{/if}
<div class="row">
    <div class="span2">
        {$this->forms('add')->label('username')}
    </div>
    <div class="span1">
        {$this->forms('add')->element('username')}
    </div>
</div>
<div class="row">
    <div class="span2">
        {$this->forms('add')->label('email')}
    </div>
    <div class="span1"> 
        {$this->forms('add')->element('email')}
    </div>
</div>
<div class="row">
    <div class="span2">
        {$this->forms('add')->label('homepage')}
    </div>
    <div class="span1"> 
        {$this->forms('add')->element('homepage')}
    </div>
</div>
<div class="row">
    <div class="span2">
        <img id="captcha_image" src="{$this->baseUrl}{$this->routes->captcha}?r={mt_rand()}">
    </div>
    <div class="span1">
        <i id="icon-captcha-refresh" class="icon-refresh" onclick="rsvp_captcha();"></i>
        {$this->forms('add')->element('captcha')}
    </div>
    
</div>
<div class="row">
    <div class="span2">
        {$this->forms('add')->label('text')}
    </div>
    <div class="span1"> 
        {$this->forms('add')->element('text')}
    </div>
</div>
<div class="row">
    <div class="span2">
        
    </div>
    <div class="span1">
        {$this->forms('add')->element('submit')}
    </div>
</div>
{if !$ajax}
{$this->forms('add')->close()}
{/if}