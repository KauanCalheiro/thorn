export default {
    slots: {
        item: 'bg-accented/20 px-4 rounded-lg',
    },
    variants: {
        disabled: {
            true: {
                trigger: 'cursor-not-allowed opacity-75'
            }
        }
    }
}
