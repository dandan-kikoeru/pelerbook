<template>
  <div class="navbar bg-[#242526] border-b border-[#38393a]">
    <div class="flex-1">
      <a class="btn btn-ghost normal-case text-xl">pelerbook</a>
    </div>
    <div class="flex-none gap-2">
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img src="guest.png" />
          </div>
        </label>
        <ul
          tabindex="0"
          class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52"
        >
          <li>
            <a class="justify-between">
              Profile
              <span class="badge">New</span>
            </a>
          </li>
          <li><a>Settings</a></li>
          <li><Link href="/logout" as="button" method="post"><span class="material-symbols-outlined">
            logout
            </span>Log out</Link></li>
        </ul>
      </div>
    </div>
  </div>
</template>
