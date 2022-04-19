<section class="operator-nav">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light pl-0">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
             </button>
        
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul>
                <li class="{{ (Request::segment(2) == 'quotations' && Request::segment(3) == '') ? 'active' : '' }}"><a href="{{ route('operators.quotations') }}">Quotes</a>
                    </li>
                    <li class="{{ (Request::segment(2) == 'special-invites') ? 'active' : '' }}"><a href="{{ route('operators.special-invites') }}">Special Invites Received</a>
                    </li>
                    <li class="{{ (Request::segment(2) == 'quotations' && Request::segment(3) == 'sent') ? 'active' : '' }}"><a href="{{ route('operators.quotations.sent') }}">Quotes Sent</a>
                    </li>
                    <li class="{{ (Request::segment(3) == 'accepted') ? 'active' : '' }}"><a href="{{ route('operators.quotations.accepted') }}">Accepted Quotes</a>
                    </li>
                    <li class="{{ (Request::segment(2) == 'wallet') ? 'active' : '' }}"><a href="{{ route('operators.wallet') }}">My Wallet</a>
                    </li>
                </ul>
            </div>
        </nav>


    </div>
</section>