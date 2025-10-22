use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|max:10240', 
        ]);
    
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
        
            //중복방지
            $fileName = time() . '.' . $image->getClientOriginalExtension();
        
            // (3) Intervention Image를 사용하여 이미지 리사이징
            // 가로 300px 기준으로 비율에 맞게 리사이징
            $resizedImage = Image::make($image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        
            // (4) 리사이징된 이미지를 storage에 저장
            // Storage::put() 메소드는 파일 내용과 경로를 인자로 받습니다.
            // toPng(), toJpeg() 등으로 포맷을 지정할 수 있습니다.
            Storage::put('public/profiles/' . $fileName, (string) $resizedImage->encode());
        
        
            // (5) DB에 파일 경로 저장
            // 예시: Auth::user()->update(['profile_image_path' => 'profiles/' . $fileName]);
            $user = Auth::user();
            $user->profile_image_path = 'profiles/' . $fileName; // DB 컬럼에 경로 저장
            $user->save();
        }
    
        // ... 나머지 로직
    }

}