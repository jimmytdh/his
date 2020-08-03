<form action="{{ url('dietary/save') }}" method="post">
    {{ csrf_field() }}
    <div class="modal-body" id="diet-content">
        <input type="hidden" name="code" value="{{ $code }}" />
        <div class="form-group">
            <label>Weight</label>
            <div class="input-group">
                <input type="text" value="{{ $weight }}" class="form-control" name="weight" autocomplete="off">
                <span class="input-group-addon">kg</span>
            </div>
        </div>
        <div class="form-group">
            <label>Height</label>
            <div class="input-group">

                <input type="text" value="{{ $height }}" class="form-control" name="height" autocomplete="off">
                <span class="input-group-addon">m</span>
            </div>
        </div>
        <div class="form-group">
            <?php
                $diet = \App\Http\Controllers\DietaryController::getDietList();
            ?>
            <label>Select Diet</label>
            <select class="form-control" name="diet">
                @foreach($diet as $d => $v)
                    <option value="{{ $d }}" {{ ($diet_code==$d) ? 'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Additional Info</label>
            <textarea class="form-control" style="resize: none;" rows="5" name="remarks">{{ $remarks }}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="submit" id="delete_link" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
    </div>
</form>