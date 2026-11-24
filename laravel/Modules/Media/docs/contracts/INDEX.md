---
title: "INDEX contratti — Media"
type: index
module: Media
status: active
created: 2026-11-23
updated: 2026-11-24
qmd: "media contracts index copertura invarianti pest group"
---

# Indice dei contratti — Media

Un contratto per ognuna delle 51 Action di `app/Actions` (`find app/Actions -name '*.php' | wc -l`: 51, tutte con marker
`@contract` nel docblock). Formato e regole: [README.md](README.md).

Copertura = `coperto` solo se per ogni ID esiste `->group('<ID>')` nei test del modulo
(`rg -n "group\('MEDIA-" Modules/Media/tests`: oggi solo `MEDIA-STRIP-INV-1`..`5`, in
`tests/Unit/Actions/Image/StripImageMetadataActionTest.php`; gli altri gruppi presenti sono `no-media-db` e `media-db`, non ID).
Comando per le invarianti coperte: `vendor/bin/pest Modules/Media/tests --group=<ID>`; per le altre darebbe zero test.

| Contratto | Classe (`Modules\Media\...`) | Invarianti | Copertura |
|---|---|---|---|
| [attach-media-action](attach-media-action.md) | `Actions\AttachMediaAction` | `ATTACH-MEDIA-INV-1` | non coperto |
| [base-s3-action](base-s3-action.md) | `Actions\S3\BaseS3Action` | `BASE-S3-INV-1`..`2` | non coperto |
| [build-config-debug-data-action](build-config-debug-data-action.md) | `Actions\Diagnostic\S3\BuildConfigDebugDataAction` | `BUILD-CONFIG-DEBUG-DATA-INV-1`..`2` | non coperto |
| [check-bucket-policy-action](check-bucket-policy-action.md) | `Actions\Diagnostic\S3\CheckBucketPolicyAction` | `CHECK-BUCKET-POLICY-INV-1`..`2` | non coperto |
| [check-file-exists-action](check-file-exists-action.md) | `Actions\S3\CheckFileExistsAction` | `CHECK-FILE-EXISTS-INV-1`..`2` | non coperto |
| [convert-srt-to-vtt-action](convert-srt-to-vtt-action.md) | `Actions\Subtitle\ConvertSrtToVttAction` | `CONVERT-SRT-TO-VTT-INV-1`..`2` | non coperto |
| [convert-video-action](convert-video-action.md) | `Actions\Video\ConvertVideoAction` | `CONVERT-VIDEO-INV-1`..`2` | non coperto |
| [convert-video-by-convert-data-action](convert-video-by-convert-data-action.md) | `Actions\Video\ConvertVideoByConvertDataAction` | `CONVERT-VIDEO-BY-CONVERT-DATA-INV-1`..`2` | non coperto |
| [convert-video-by-media-convert-action](convert-video-by-media-convert-action.md) | `Actions\Video\ConvertVideoByMediaConvertAction` | `CONVERT-VIDEO-BY-MEDIA-CONVERT-INV-1`..`3` | non coperto |
| [create-filesystem-s3-client-action](create-filesystem-s3-client-action.md) | `Actions\Diagnostic\Aws\CreateFilesystemS3ClientAction` | `CREATE-FILESYSTEM-S3-CLIENT-INV-1`..`2` | non coperto |
| [create-filesystem-sts-client-action](create-filesystem-sts-client-action.md) | `Actions\Diagnostic\Aws\CreateFilesystemStsClientAction` | `CREATE-FILESYSTEM-STS-CLIENT-INV-1` | non coperto |
| [delete-file-action](delete-file-action.md) | `Actions\S3\DeleteFileAction` | `DELETE-FILE-INV-1`..`2` | non coperto |
| [extract-subtitle-plain-text-action](extract-subtitle-plain-text-action.md) | `Actions\Subtitle\ExtractSubtitlePlainTextAction` | `EXTRACT-SUBTITLE-PLAIN-TEXT-INV-1` | non coperto |
| [format-debug-output-action](format-debug-output-action.md) | `Actions\Diagnostic\S3\FormatDebugOutputAction` | `FORMAT-DEBUG-OUTPUT-INV-1`..`3` | non coperto |
| [generate-temporary-upload-path-action](generate-temporary-upload-path-action.md) | `Actions\GenerateTemporaryUploadPathAction` | `MEDIA-PATH-INV-1`..`4` | non coperto |
| [get-attachments-schema-action](get-attachments-schema-action.md) | `Actions\GetAttachmentsSchemaAction` | `GET-ATTACHMENTS-SCHEMA-INV-1`..`3` | non coperto |
| [get-aws-config-snapshot-action](get-aws-config-snapshot-action.md) | `Actions\Diagnostic\Aws\GetAwsConfigSnapshotAction` | `GET-AWS-CONFIG-SNAPSHOT-INV-1`..`2` | non coperto |
| [get-cloud-front-signed-url-action](get-cloud-front-signed-url-action.md) | `Actions\CloudFront\GetCloudFrontSignedUrlAction` | `GET-CLOUD-FRONT-SIGNED-URL-INV-1`..`2` | non coperto |
| [get-effective-upload-limit-action](get-effective-upload-limit-action.md) | `Actions\Upload\GetEffectiveUploadLimitAction` | `GET-EFFECTIVE-UPLOAD-LIMIT-INV-1`..`2` | non coperto |
| [get-file-info-action](get-file-info-action.md) | `Actions\S3\GetFileInfoAction` | `GET-FILE-INFO-INV-1`..`2` | non coperto |
| [get-filesystem-adapter-action](get-filesystem-adapter-action.md) | `Actions\Storage\GetFilesystemAdapterAction` | `GET-FILESYSTEM-ADAPTER-INV-1` | non coperto |
| [get-temporary-upload-conversion-path-action](get-temporary-upload-conversion-path-action.md) | `Actions\TemporaryUpload\GetTemporaryUploadConversionPathAction` | `GET-TEMPORARY-UPLOAD-CONVERSION-PATH-INV-1`..`2` | non coperto |
| [get-temporary-upload-path-action](get-temporary-upload-path-action.md) | `Actions\TemporaryUpload\GetTemporaryUploadPathAction` | `GET-TEMPORARY-UPLOAD-PATH-INV-1`..`2` | non coperto |
| [get-temporary-upload-responsive-path-action](get-temporary-upload-responsive-path-action.md) | `Actions\TemporaryUpload\GetTemporaryUploadResponsivePathAction` | `GET-TEMPORARY-UPLOAD-RESPONSIVE-PATH-INV-1`..`2` | non coperto |
| [get-video-duration-action](get-video-duration-action.md) | `Actions\Video\GetVideoDurationAction` | `GET-VIDEO-DURATION-INV-1` | non coperto |
| [get-video-frame-content-action](get-video-frame-content-action.md) | `Actions\Video\GetVideoFrameContentAction` | `GET-VIDEO-FRAME-CONTENT-INV-1`..`2` | non coperto |
| [get-video-screenshot-action](get-video-screenshot-action.md) | `Actions\Video\GetVideoScreenshotAction` | `GET-VIDEO-SCREENSHOT-INV-1` | non coperto |
| [merge](merge.md) | `Actions\Image\Merge` | `MERGE-INV-1`..`3` | non coperto |
| [parse-subtitle-xml-action](parse-subtitle-xml-action.md) | `Actions\Subtitle\ParseSubtitleXmlAction` | `PARSE-SUBTITLE-XML-INV-1`..`2` | non coperto |
| [resolve-aws-s3-error-solution-action](resolve-aws-s3-error-solution-action.md) | `Actions\Diagnostic\Aws\ResolveAwsS3ErrorSolutionAction` | `RESOLVE-AWS-S3-ERROR-SOLUTION-INV-1`..`2` | non coperto |
| [resolve-media-exporter-action](resolve-media-exporter-action.md) | `Actions\Ffmpeg\ResolveMediaExporterAction` | `RESOLVE-MEDIA-EXPORTER-INV-1`..`2` | non coperto |
| [run-full-aws-diagnostic-action](run-full-aws-diagnostic-action.md) | `Actions\Diagnostic\Aws\RunFullAwsDiagnosticAction` | `RUN-FULL-AWS-DIAGNOSTIC-INV-1` | non coperto |
| [run-s3-save-test-action](run-s3-save-test-action.md) | `Actions\Diagnostic\S3\RunS3SaveTestAction` | `RUN-S3-SAVE-TEST-INV-1`..`2` | non coperto |
| [save-attachments-action](save-attachments-action.md) | `Actions\SaveAttachmentsAction` | `MEDIA-ATTACH-INV-1`..`4` | non coperto |
| [stream-video-action](stream-video-action.md) | `Actions\Stream\StreamVideoAction` | `STREAM-VIDEO-INV-1`..`4` | non coperto |
| [strip-image-metadata-action](strip-image-metadata-action.md) | `Actions\Image\StripImageMetadataAction` | `MEDIA-STRIP-INV-1`..`5` | coperto |
| [svg-exists-action](svg-exists-action.md) | `Actions\Image\SvgExistsAction` | `SVG-EXISTS-INV-1`..`3` | non coperto |
| [test-bucket-permissions-action](test-bucket-permissions-action.md) | `Actions\Diagnostic\S3\TestBucketPermissionsAction` | `TEST-BUCKET-PERMISSIONS-INV-1`..`2` | non coperto |
| [test-cloud-front-config-action](test-cloud-front-config-action.md) | `Actions\Diagnostic\Aws\TestCloudFrontConfigAction` | `TEST-CLOUD-FRONT-CONFIG-INV-1`..`2` | non coperto |
| [test-cloud-front-connection-action](test-cloud-front-connection-action.md) | `Actions\Diagnostic\S3\TestCloudFrontConnectionAction` | `TEST-CLOUD-FRONT-CONNECTION-INV-1`..`2` | non coperto |
| [test-cloud-front-signed-urls-action](test-cloud-front-signed-urls-action.md) | `Actions\Diagnostic\Aws\TestCloudFrontSignedUrlsAction` | `TEST-CLOUD-FRONT-SIGNED-URLS-INV-1`..`2` | non coperto |
| [test-connection-details-action](test-connection-details-action.md) | `Actions\Diagnostic\S3\TestConnectionDetailsAction` | `TEST-CONNECTION-DETAILS-INV-1`..`2` | non coperto |
| [test-credentials-action](test-credentials-action.md) | `Actions\Diagnostic\S3\TestCredentialsAction` | `TEST-CREDENTIALS-INV-1`..`2` | non coperto |
| [test-file-upload-download-action](test-file-upload-download-action.md) | `Actions\Diagnostic\S3\TestFileUploadDownloadAction` | `TEST-FILE-UPLOAD-DOWNLOAD-INV-1`..`2` | non coperto |
| [test-iam-credentials-action](test-iam-credentials-action.md) | `Actions\Diagnostic\Aws\TestIamCredentialsAction` | `TEST-IAM-CREDENTIALS-INV-1`..`2` | non coperto |
| [test-iam-policies-action](test-iam-policies-action.md) | `Actions\Diagnostic\Aws\TestIamPoliciesAction` | `TEST-IAM-POLICIES-INV-1` | non coperto |
| [test-s3-connection-action](test-s3-connection-action.md) | `Actions\Diagnostic\Aws\TestS3ConnectionAction` | `TEST-S3-CONNECTION-INV-1`..`2` | non coperto |
| [test-s3-file-operations-action](test-s3-file-operations-action.md) | `Actions\Diagnostic\Aws\TestS3FileOperationsAction` | `TEST-S3-FILE-OPERATIONS-INV-1`..`2` | non coperto |
| [test-s3-permissions-action](test-s3-permissions-action.md) | `Actions\Diagnostic\Aws\TestS3PermissionsAction` | `TEST-S3-PERMISSIONS-INV-1` | non coperto |
| [update-model-subtitle-field-action](update-model-subtitle-field-action.md) | `Actions\Subtitle\UpdateModelSubtitleFieldAction` | `UPDATE-MODEL-SUBTITLE-FIELD-INV-1` | non coperto |
| [upload-file-action](upload-file-action.md) | `Actions\S3\UploadFileAction` | `UPLOAD-FILE-INV-1`..`3` | non coperto |

Interfacce: [path-generator](path-generator.md) (`PathGenerator`, `PathGeneratorContract`, oggi senza implementazioni).
Totale: 51 contratti, 1 con copertura Pest completa.
