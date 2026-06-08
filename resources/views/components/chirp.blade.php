@props(['chirp'])

<div class="card bg-base-100 shadow">
    <div class="card-body">
        <div class="flex space-x-3">
            @if ($chirp->user)
                <div class="avatar">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/{{ urlencode($chirp->user->email) }}"
                            alt="{{ $chirp->user->name }}'s avatar" class="rounded-full" />
                    </div>
                </div>
            @else
                <div class="avatar placeholder">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=stealth"
                            alt="Anonymous User" class="rounded-full" />
                    </div>
                </div>
            @endif

            <div class="min-w-0 flex-1">
                <div class="flex justify-between w-full">
                    <div class="flex items-center gap-1">
                        <span class="text-sm font-semibold">{{ $chirp->user ? $chirp->user->name : 'Anonymous' }}</span>
                        <span class="text-base-content/60">·</span>
                        <span class="text-sm text-base-content/60">{{ $chirp->created_at->diffForHumans() }}</span>
                        @if ($chirp->updated_at->gt($chirp->created_at->addSeconds(5)))
                            <span class="text-base-content/60">·</span>
                            <span class="text-sm text-base-content/60 italic">edited</span>
                        @endif
                    </div>

                    {{-- <!-- Replace the temporary @php block and $canEdit check with: --> --}}
                    @can('update', $chirp)
                        <div class="flex gap-1">
                            <a href="/chirps/{{ $chirp->id }}/edit" class="btn btn-ghost btn-xs">
                                Edit
                            </a>
                            <form method="POST" action="/chirps/{{ $chirp->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this chirp?')"
                                    class="btn btn-ghost btn-xs text-error">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
                <p class="mt-1">{{ $chirp->message }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 space-y-4 border-t pt-4">
    @if ($chirp->replies->isNotEmpty())
        <div class="space-y-3">
            @foreach ($chirp->replies as $reply)
                <div class="rounded-xl bg-base-200 p-3">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="font-semibold">
                            {{ $reply->user?->name ?? 'Anonymous' }}
                        </span>
                        <span class="text-base-content/60">·</span>
                        <span class="text-base-content/60">
                            {{ $reply->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <p class="mt-1 text-sm">
                        {{ $reply->message }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    @auth
        <form method="POST" action="/chirps/{{ $chirp->id }}/replies">
            @csrf

            <div class="form-control w-full">
                <textarea name="reply_message"
                    class="textarea textarea-bordered w-full resize-none @error('reply_message') textarea-error @enderror"
                    rows="2" maxlength="255" placeholder="Write a reply..." required>{{ old('reply_message') }}</textarea>

                @error('reply_message')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="mt-3 flex justify-end">
                <button type="submit" class="btn btn-primary btn-xs">
                    Reply
                </button>
            </div>
        </form>
    @endauth
</div>