@forelse ($message as $message)
    <li>
        <h4>eDESK ID {{$message->name}} </h4><span class="chat_time">{{$message->created_at->format('d-m-Y h:i A')}}</span>
        <p>{{$message->message}}</p>
    </li>
@empty
    <li>No Messages</li>
@endforelse
<li>
    <input type="hidden" name="thread_id" class="thread_id" value="{{$threadid}}" />
</li>