import type { MuscleGroup } from "./MuscleGroup";

export default interface Exercise {
    id: number;
    name: string;
    gif: File | string;
    muscle_group_id: number;
    muscle: MuscleGroup;
}