<div id="sidebar" class="nav-collapse">
    <!-- sidebar menu start-->
    <div class="leftside-navigation" tabindex="5000" style="overflow: hidden; outline: none;">
        <ul class="sidebar-menu" id="nav-accordion">
            @foreach (config('constants.sidebars') as $itemSidebar)
            @if (isset($itemSidebar['sub_menu']))
            @can($itemSidebar['can'])
            <li class="sub-menu">
                <a href="{{ $itemSidebar['router_name'] }}">
                    <span>{{ $itemSidebar['label'] }}</span>
                    <span class="dcjq-icon"></span>
                </a>
                <ul class="sub">
                    @foreach ($itemSidebar['sub_menu'] as $subItem)
                    @can($subItem['can'])
                    <li><a href="{{ route($subItem['router_name']) }}">{{ $subItem['label'] }}</a></li>
                    @endcan
                    @endforeach
                </ul>
            </li>
            @endcan

            @else
            @if($itemSidebar['can'])
            @can($itemSidebar['can'])
            <li>
                <a href="{{ route($itemSidebar['router_name']) }}">
                    <span>{{ $itemSidebar['label'] }}</span>
                </a>
            </li>
            @endcan
            @else
            <li>
                <a href="{{ route($itemSidebar['router_name']) }}">
                    <span>{{ $itemSidebar['label'] }}</span>
                </a>
            </li>
            @endif

            @endif
            @endforeach
        </ul>
    </div>
    <!-- sidebar menu end-->
    <div id="ascrail2000" class="nicescroll-rails"
        style="width: 3px; z-index: auto; cursor: default; position: absolute; top: 0px; left: 237px; height: 299px; opacity: 0; display: block;">
        <div
            style="position: relative; top: 0px; float: right; width: 3px; height: 146px; background-color: rgb(139, 92, 126); border: 0px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 0px;">
        </div>
    </div>
    <div id="ascrail2000-hr" class="nicescroll-rails"
        style="height: 3px; z-index: auto; top: 296px; left: 0px; position: absolute; cursor: default; display: none; width: 237px; opacity: 0;">
        <div
            style="position: relative; top: 0px; height: 3px; width: 240px; background-color: rgb(139, 92, 126); border: 0px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 0px;">
        </div>
    </div>
</div>