<div class="about-section">
   <div class="text-content">
     <div class="span7 offset1">
        <div class="secure">Upload form</div>
        {!! Form::open(array('url'=>'apply/upload','method'=>'POST', 'files'=>true)) !!}
         <div class="control-group">
          <div class="controls">
          {!! Form::file('file') !!}
        </div>
        </div>
        <div id="success"> </div>
      {!! Form::submit('Submit', array('class'=>'send-btn')) !!}
      {!! Form::close() !!}
      </div>
   </div>
</div>