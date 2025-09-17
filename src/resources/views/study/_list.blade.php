        @php
            $today = (new DateTime()) ->setTime(0, 0);
        @endphp
        @foreach($study as $key => $val)
            @php
                $deadlineDate = DateTime::createFromFormat('Y-m-d',  $val['deadline']) ->setTime(0, 0);;
                $d_day = $deadlineDate -> diff($today);
                $d_day_val = 'D';
                $d_day_class = "cm-label ";
                //dd((int)$d_day -> format('%R%a'));/
                if((int)$d_day -> format('%R%a') === 0){
                    $d_day_val = 'Today';
                    $d_day_class .= "today";
                }
                else if($d_day -> invert === 0){
                    $d_day_val = '마감';
                    $d_day_class .= "deadline";
                }else{
                    $d_day_val .= $d_day -> format('%R%a');
                    $d_day_class = "";
                }
            @endphp
            <li class="list {{ $d_day -> invert === 0 ? 'deadline' : ''}}">
                <a href="{{ route('study.show', $val->id) }}">
                    <div class="flex-wrap">
                        <p class="list-tit" title="{{$val['title']}}">
                            {{$val['title']}}
                            
                        </p>
                        <div class="list-deadline">
                            <span class="{{$d_day_class}}">{{$d_day_val}}</span>
                            <span class="helper-text">({{ $val['deadline'] }})</span>
                        </div>
                    </div>

                    <div>
                        <p><i class="xi-marker-circle"></i>{{(int)$d_day -> format('%R%a')}}</p>
                        @if($val['is_offline'] === 0 )
                            <p>{{$val['regions_name']}}</p>
                            <p class="helper-text">{{ !empty($val['location']) ? '('.$val['location'].')' : ''}}</p>
                        @else
                            <p>Online</p>
                        @endif
                    </div>
                    <div>
                        <p><i class="xi-calendar"></i></p>
                        {{ $val['start_date'] }} ~ {{ !empty($val['end_date']) ? $val['end_date']:'기한없음' }}
                    </div>
                    <div class="participants-wrap">
                        <div class="participants-count">
                            <p><i class="xi-community"></i></p>
                            <div class="progress-bar">
                                <div class="progress" style="width: {{ (100 / $val['max_members']) * $val -> members -> count() }}%"></div>
                                <div>
                                    <span>{{ $val -> members -> count() }}</span>
                                    <span>/</span>
                                    <span>
                                        {{ $val['max_members'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-wrap">
                            <ul class="participants-profile">
                                <li><i class="xi-user"></i></li>
                                @foreach($val -> members as $in_key => $in_val)
                                <li>
                                    @if($in_key > 1)
                                        <span class="xi-plus-circle-o"></span>
                                        @break
                                    @else
                                        <span class="{{ $in_val['members_name'] }}"><i class="{{$in_val['study_member_rank'] === 0 ?? "xi-crown"}}"></i></span>
                                    @endif
                                    </li>
                                @endforeach
                            </ul>
                            <p>
                                <span><i class="xi-eye-o"></i></span>
                                <span>{{$val['views']}}</span></p>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach