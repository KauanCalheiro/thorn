export default {
    slots: {
        thead: [
            '[&>tr>th:first-child]:rounded-s-lg [&>tr>th:last-child]:rounded-e-lg',
            '[&>tr]:after:absolute [&>tr]:after:inset-x-0 [&>tr]:after:bottom-0 [&>tr]:after:h-px [&>tr]:after:bg-(--ui-border-accented)',
            'bg-accented/50 relative px-6 sticky top-0 inset-x-0 z-[1] backdrop-blur',
        ],
        tbody:
            'divide-none [&>tr]:data-[selectable=true]:hover:bg-elevated/50 [&>tr]:data-[selectable=true]:focus-visible:outline-primary',
    }
}