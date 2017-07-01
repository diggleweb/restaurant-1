<ul class="nav">
	<li {{ (Request::is('admin/stores*') ? 'class=active' : '') }}>
		<a href="{!! route('admin.stores.index') !!}">
		<i class="glyphicon glyphicon-record"></i>
		stores</a>
	</li>
	<li {{ (Request::is('admin/products*') ? 'class=active' : '') }}>
		<a href="{!! route('admin.products.index') !!}">
		<i class="glyphicon glyphicon-record"></i>
		products </a>
	</li>
	<li {{ (Request::is('admin/customers*') ? 'class=active' : '') }}>
		<a href="{!! route('admin.customers.index') !!}">
		<i class="glyphicon glyphicon-record"></i>
		customers </a>
	</li>
	<li {{ (Request::is('admin/orders*') ? 'class=active' : '') }}>
		<a href="{!! route('admin.orders.index') !!}">
		<i class="glyphicon glyphicon-record"></i>
		Orders </a>
	</li>
</ul>