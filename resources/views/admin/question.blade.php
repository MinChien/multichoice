@extends('layouts.admin_main')

@section('content')
<div class="container">
		<div class="row mt-3 mb-3 justify-content-center">
			<div class="col-lg-12">
				<div class="card">
          <div class="card-header">
            <div class="container">
              <div class="row justify-content-between">
                <div class="col-4"></div>
                <div class="col-4"><h4 class="text-uppercase mb-0">Ngân hàng câu hỏi</h4></div>
                <div class="col-4 text-right">
                  <a href="#" class="btn btn-outline-success mr-1" data-toggle="modal" data-target="#add_question">Thêm Câu hỏi</a><a href="#" class="btn btn-outline-dark btn-sm mx-0 mt-2" data-toggle="modal" data-target="#trash_question">Rác</a>

                    <!-- modal của thêm câu hỏi-->
                    <div class="modal fade" id="add_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                          <div class="modal-body text-left">
                                            <form action="{{ url('/admin/question/add_question') }}" method="POST" >
                                                @csrf
                                                <label class="mb-0 pl-2">Thuộc Chương:</label>
                                                <select name="chapter_id" class="form-control mb-2">
                                                  <option><p>-Chọn chương:</p></option>
                                                  @if(count($chapters) > 0)                                                 
                                                    @foreach($chapters as $key => $chapter)
                                                      <option value="{{$chapter->id}}">{{$chapter->name}} - {{ $chapter->subject->name}}</option>
                                                    @endforeach
                                                  @endif
                                                </select>
                                                <label class="mb-0 pl-2">Câu hỏi:</label>
                                                <input type="text" class="form-control mb-2" name="content" required placeholder="Nhập câu hỏi....">
                                                <div class="container">
                                                  <div class="row">
                                                    <div class="col-6">
                                                      <input type="text" name="name[]" placeholder="Option 1...." class="form-control my-1" required>
                                                      <input type="text" name="name[]" placeholder="Option 2...." class="form-control my-1" required>
                                                      <input type="text" name="name[]" placeholder="Option 3...." class="form-control my-1" required>
                                                      <input type="text" name="name[]" placeholder="Option 4...." class="form-control my-1" required>
                                                    </div>
                                                    <div class="col-6">
                                                      <div class="form-check mt-3 mb-2">
                                                        <input type="radio" name="answer" value="option1">
                                                        <label>Option 1 đúng</label>
                                                      </div>
                                                      <div class="form-check mt-2 mb-1">
                                                        <input type="radio" name="answer" value="option2">
                                                        <label>Option 2 đúng</label>
                                                      </div>
                                                      <div class="form-check  mt-2 mb-1">
                                                        <input type="radio" name="answer" value="option3">
                                                        <label>Option 3 đúng</label>
                                                      </div>
                                                      <div class="form-check my-2">
                                                        <input type="radio" name="answer" value="option4">
                                                        <label>Option 4 đúng</label>
                                                      </div> 
                                                    </div>
                                                  </div>
                                                </div> 
                                          </div>
                                          <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary btn-sm" name="add">Lưu</button> 
                                            </form>
                                            <a href='#' class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</a>
                                          </div>
                                </div>
                              </div>
                    </div>
                    <!-- </div> -->
                 <!-- kết thúc modal của thêm câu hỏi -->

                      <!-- modal của thư mục rác-->
                <div class="modal fade" id="trash_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content text-left">
                                      <div class="modal-body">
                                          <table class="table table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th>#</th>
                                                    <th>Câu hỏi đã xóa</th>
                                                    <th>Thuộc</th> 
                                                    <th>Hiệu chỉnh</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($trash_questions) > 0)
                                                    @foreach($trash_questions as $key => $question)
                                                      <tr>
                                                        <th>{{++$key}}</th>
                                                        <td class="w-50">{{ $question->content }}</td>
                                                        <td> {{ $question->chapter->name }} - {{$question->chapter->subject->name}}</td>
                                                        <td><a href="{{url('/admin/question/restore_trash', $question->id)}}" class="btn btn-info btn-sm">Khôi phục</a></td>
                                                      </tr>
                                                    @endforeach
                                                  @endif                                                
                                                </tbody>
                                          </table> 
                                      </div>
                                      <div class="modal-footer">
                                        <a href='#' class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</a>
                                      </div>
                            </div>
                          </div>
                </div>
                <!-- </div> -->
             <!-- kết thúc modal của thư mục rác -->

                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            @foreach($subjects as $key => $subject)
              <h2 class="text-center">{{$subject->name}}</h2>
              @foreach($subject->chapter as $key1 => $chapter)
              <table class="table card-text table-bordered table-sm table-hover">
                <thead>
                  <tr>
                    <th colspan="3"><h5>{{ $chapter->name }} : {{ $chapter->description }}</h5></th>
                  </tr>
                </thead>
                <tbody>
                @foreach($chapter->question as $key2=> $question)  
                  <tr data-toggle="collapse" data-target="#demo{{$key1}}-{{$key2}}" class="accordion-toggle">
                    <td class="w-75">{{$question->content}}</td>                    
                    <td class="text-center">
                      <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#change_content{{ $key }}-{{ $key1 }}-{{ $key2 }}">Sửa</a>
                      <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#del_question{{ $key }}-{{ $key1 }}-{{ $key2 }}">Xóa</a>
                    </td>
                  </tr>
                  <!-- modal của sửa tên câu hỏi-->
                              <div class="modal fade" id="change_content{{ $key }}-{{$key1}}-{{$key2}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true" >
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-body">
                                    <form action="{{ url('/admin/question/change_content', $question->id) }}" method="POST" >
                                        @csrf
                                      <div class="form-group">
                                        <input type="text" class="form-control" name="content" value="{{ $question->content }}">
                                      </div>
                                      <div class="container">
                                        <div class="row">
                                          <div class="col-6">
                                            @foreach($question->option->name as $key4 => $option)
                                            <input type="text" name="name_change[]" placeholder="Option {{++$key4}}...." class="form-control my-1" required value="{{ $option }}">
                                            @endforeach
                                          </div>
                                          <div class="col-6 mt-2">
                                            @foreach($question->option->name as $key5 => $option)
                                            <div class="form-check mt-2 mb-1">
                                              <input type="radio" name="answer_change" value="option{{++$key5}}" @if($option == $question->option->answer) checked @endif>
                                              <label>Option {{$key5}} đúng</label>
                                            </div>
                                            @endforeach 
                                          </div>
                                        </div>
                                      </div> 
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning btn-sm" name="change_content">Lưu</button>
                                    <a href='#' class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</a>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <!-- </div> -->
                      <!-- kết thúc modal của sửa câu hỏi -->

                    <!-- modal của xóa câu hỏi-->
                              <div class="modal fade" id="del_question{{ $key }}-{{ $key1 }}-{{ $key2 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                    <div class="modal-body">
                                        Bạn có thực sự muốn xóa câu hỏi này?
                                        <p><small>"Có thể lấy lại dữ liệu trong tập tin rác."</small></p>
                                    </div>
                                    <div class="modal-footer">
                                      <form action="{{ url('/admin/question/del_question', $question->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm" name="del_question">Xác nhận</button>
                                      </form>
                                      <a href='#' class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          <!-- </div>content -->
                         <!-- kết thúc modal của xóa câu hỏi  -->
                  <tr>
                    <td colspan="12">
                      <div class="accordian-body collapse" id="demo{{$key1}}-{{$key2}}">
                        <table class="container">
                          <tbody>
                            @foreach($question->option->name as $key3=>$option )
                            <tr>
                              <td class="w-75">{{ $option }}</td>
                              <td class="text-center">
                                @if($option == $question->option->answer)
                                    <span class="text-success font-weight-bold">&#10003;</span>                                
                                @endif
                                
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </td>  
                  </tr>  
                @endforeach  
                </tbody>
              </table>
              @endforeach
            @endforeach
          </div>
        </div>


			</div>
		</div>
	</div>	
@endsection