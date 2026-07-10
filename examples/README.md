# Examples

Copy the configuration template before running an example:

```bash
cp examples/config.example.php examples/config.php
```

Enter your test tokens and IDs in `examples/config.php`. This file is ignored by Git.

Run an example from the project root:

```bash
php examples/listNetwork.php
```

For the local video example, place a file at `examples/files/video.mp4`. A video token is generated only when the matching network property has `video_upload_type = 1`.
