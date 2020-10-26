<div class="card-body">
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-8">
            <input type="text"
                   class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name"
                   placeholder="Enter Name" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="height" class="col-sm-2 col-form-label">Height</label>
        <div class="col-sm-8">
            <input type="number"
                   class="form-control {{ $errors->has('height') ? 'is-invalid' : '' }}" id="height" name="height"
                   placeholder="Enter Height" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="mass" class="col-sm-2 col-form-label">Mass</label>
        <div class="col-sm-8">
            <input type="number"
                   class="form-control {{ $errors->has('mass') ? 'is-invalid' : '' }}" id="mass" name="mass"
                   placeholder="Enter Mass" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="gender" class="col-sm-2 col-form-label">Gender</label>
        <div class="col-sm-8">
            <select id="gender" name="gender" required class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                <option value="">--Select Gender--</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="hair_color" class="col-sm-2 col-form-label">Hair Color</label>
        <div class="col-sm-8">
            <input type="text"
                   class="form-control {{ $errors->has('hair_color') ? 'is-invalid' : '' }}" id="hair_color" name="hair_color"
                   placeholder="Enter Hair Color" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="birth_year" class="col-sm-2 col-form-label">Birth Year</label>
        <div class="col-sm-8">
            <input type="text"
                   class="form-control {{ $errors->has('birth_year') ? 'is-invalid' : '' }}" id="birth_year" name="birth_year"
                   placeholder="Enter Birth Year" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="homeworld_name" class="col-sm-2 col-form-label">Homeworld</label>
        <div class="col-sm-8">
            <select id="homeworld_name" name="homeworld_name" class="form-control {{ $errors->has('homeworld_name') ? 'is-invalid' : '' }}" required>
                <option value="">--Select Homeworld--</option>
                @foreach ($homeworlds as $homeworld)
                    <option value="{{ $homeworld }}">{{$homeworld}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="species_name" class="col-sm-2 col-form-label">Species</label>
        <div class="col-sm-8">
            <select id="species_name" name="species_name" class="form-control {{ $errors->has('species_name') ? 'is-invalid' : '' }}">
                <option value="">--Select Species--</option>
                @foreach ($species as $specie)
                    <option value="{{ $specie }}">{{$specie}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<!-- /.card-body -->

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
