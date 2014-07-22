<form name="{{$src}}_form" method = 'post' action ='/'>
    <select name = 'category_id' id ='select_cat'>
        <option value = '0'>Filter By Job Type</option>
        @foreach($categories as $category)
        <option value = "{{$category->id}}">{{$category->name}}</option>
        @endforeach
    </select>
    <input type="text" name = "zip" placeholder="Zip Code" />
    <select id ='select_radius'  name = 'radius'>
        <option value = '0'>Radius</option>
        <option value = '1'>1 mile</option>
        <option value = '2'>2 mile</option>
        <option value = '5'>5 mile</option>
        <option value = '10'>10 mile</option>
        <option value = '15'>15 mile</option>
        <option value = '25'>25 mile</option>
        <option value = '50'>50 mile</option>
        <option value = '100'>100 mile</option>
    </select>
    <input type='hidden' name="type" value="{{$src}}">
    <button type="submit">Filter</button>
</form>