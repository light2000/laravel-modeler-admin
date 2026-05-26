<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;

class UploadController extends Controller
{
    /** 允许上传的扩展名：图片、音频、视频、Word、压缩包 */
    private const ALLOWED_EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'ico',           // 图片
        'mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac',                          // 音频
        'mp4', 'webm', 'avi', 'mov', 'mkv', 'flv', 'wmv',                    // 视频
        'doc', 'docx',                                                       // Word
        'zip', 'rar', '7z', 'tar',                                 // 压缩包
    ];

    #[OA\Post(
        operationId: 'upload',
        path: '/upload',
        tags: ['Administrator/Upload'],
        summary: '上传文件',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'file', type: 'string', format: 'binary'),
                ],
            ),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: '上传成功',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'url', type: 'string'),
                    ],
                ),
            ),
            new OA\Response(response: 401, description: '未授权'),
        ],
    )]
    public function store(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240', // 10MB
                'mimes:' . implode(',', self::ALLOWED_EXTENSIONS),
                'extensions:' . implode(',', self::ALLOWED_EXTENSIONS),
            ],
        ]);

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $request->file('file');

        $ext = $file->getClientOriginalExtension();
        $filename = Str::uuid() . ($ext ? '.' . $ext : '');

        $path = $file->storeAs('uploads', $filename, 'public');

        return response()->json([
            'key' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }
}
